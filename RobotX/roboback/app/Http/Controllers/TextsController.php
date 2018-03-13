<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TextsController extends Controller {
    /**
     * The validation rules for the connections
     * @var array
     */
    public $validations = [
        'name' => 'required',
        'text' => 'required',
    ];
    public $baseMenus = [
        'Standaard menu'    => 'Standaard menu',
        'Dance menu'        => 'Compliments menu',
        'Greetings menu'    => 'Greetings menu',
        'Interaction menu'  => 'Interaction menu',
        'Presentation menu' => 'Robotanswers menu',
    ];
    public $languages = [
        'Dutch'   => 'Dutch',
        'English' => 'English',
        'German'  => 'German',
        'French'  => 'French',
    ];

    public function reorder(Request $request, $project_id)
    {
        // Get the request data as an array
        $data = $request->all();
        // Log::info('TextsController: reorder $data '.json_encode($data));

        // Project
        App\Project::where('id', $project_id)->firstOrFail();

        foreach($data['texts'] as $order => $text_id) {
            App\Text::find($text_id)->projects()->updateExistingPivot($project_id, ['order' => $order]);
        }
    }

    public function index()
    {
        $texts = App\Text::orderBy('name', 'asc')->get();
        return view('texts.index')->withTexts($texts);
    }

    public function link(Request $request, $project_id) {
        $alltexts = App\Text::pluck('name', 'id');
        $project  = App\Project::where('id', $project_id)->firstOrFail();
        $ids      = $project->texts()->pluck('id');
        $texts    = $alltexts->filter(function ($value, $key) use ($ids) {
            return !$ids->contains($key);
        });

        // Render view
        return view('texts.link')->withTexts($texts)->withProjectId($project_id);
    }

    public function icons(Request $request, $id) {
        $data  = $request->all();
        if (isset($data['animations'])) {
            $data['animations'] = implode(';', $data['animations']);
        } else {
            $data['animations'] = '';
        }
        // Log::info('TextsController: icons $data '.json_encode($data));
        $request->session()->put('INPUTDATA', $data);
		$icons = App\Icon::orderBy('name', 'asc')->pluck('name', 'id', 'type', 'icon');
        //$icons = App\Icon::pluck('name', 'id', 'type', 'icon');
        $icons->prepend('', '-1');

        return view('texts.linkicon')->withIcons($icons)->withTextId($request->all()['text_id']);
    }

    public function saveicon(Request $request) {
        // Get the request data as an array
        $data  = $request->all();
        // Log::info('TextsController: saveicon $data '.json_encode($data));
        $input = $request->session()->get('INPUTDATA');
        // Log::info('TextsController: saveicon $input '.json_encode($input));

        if ($input['text_id'] == 'NEW')
        {
            // $text = new App\Text;
            $text = App\Text::create($input);
        }
        else
        {
            $text = App\Text::where('id', $data['text_id'])->firstOrFail();
        }
        foreach ($input as $key => $value)
        {
            if ($key == 'animations')
            {
                $text['animations'] = explode(';', $value);
            } else {
                $text->{ $key } = $value;
            }
        }
        $bhvs = App\Behavior::where('sayanimation', 'true')->get();
        $animats = [];
        foreach ($bhvs as $ani) {
            $animats += [ $ani->id => $ani->name ];
        }

        try
        {
            if ($data['icon'] != '-1')
            {
                $text['icon'] = $data['icon'];
            }
            return view('texts.textdata')->withText($text)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withAnimations($animats);
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() === 'Undefined index: texts')
            {
                return 'EMPTY INPUT';
            }
            if (strpos($e->getMessage(), 'Duplicate entry') !== false)
            {
                return 'DUPLICATE ENTRY';
            }
            return "Exception: " . $e->getMessage();
        }
    }

    public function savelink(Request $request) {
        // Get the request data as an array
        $data = $request->all();
        $prj  = App\Project::where('id', $data['project_id'])->firstOrFail();

        try
        {
            $prj->texts()->attach($data['texts']);
            $project = App\Project::where('id', $data['project_id'])->firstOrFail();
            foreach ($data['texts'] as $text)
            {
                App\Text::find($text)->projects()->updateExistingPivot($project->id, ['order' => sizeof($project->texts) + 1]);
            }
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() === 'Undefined index: texts')
            {
                return 'EMPTY INPUT';
            }
            if (strpos($e->getMessage(), 'Duplicate entry') !== false)
            {
                return 'DUPLICATE ENTRY';
            }
            return "Exception: " . $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
        // Log::info('TextsController: create $request '.json_encode($request));

        $project_id = $request->get('project_id', false);
        $bhvs = App\Behavior::where('sayanimation', 'true')->get();
        $animats = [];
        foreach ($bhvs as $ani) {
            $animats += [ $ani->id => $ani->name ];
        }
        // Render view
        return view('texts.textdata')->withProjectId($project_id)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withAnimations($animats);
    }

    /**
     * Create a new text
     * @param Request $request
     */
    public function store(Request $request) {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();

        if (isset($data['project_id']))
        {
            $project_id = $data['project_id'];
            unset($data['project_id']);
        }

        try
        {
            // Create a new record
            $created_text = App\Text::create($data);
            if (isset($project_id)) {
               $created_text->projects()->attach($project_id);
               reorder($request, $project_id);
            }
        }
        catch (\Exception $e)
        {
            Log::critical('store text: '.$e);
        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id) {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();
        if (isset($data['animations'])) {
            $data['animations'] = implode(';', $data['animations']);
        } else {
            $data['animations'] = '';
        }

        // Update the connection with the new information
        App\Text::find($id)->update($data);
    }

    /**
     * Edit a text
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $text = App\Text::where('id', $id)->firstOrFail();
        $text['animations'] = explode(';', $text['animations']);
        // Log::info('TextsController: edit $data '.json_encode($text));

        $bhvs = App\Behavior::where('sayanimation', 'true')->get();
        $animats = [];
        foreach ($bhvs as $ani) {
            $animats += [ $ani->id => $ani->name ];
        }
        return view('texts.textdata')->withText($text)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withAnimations($animats);
    }

    public function destroy(Request $request, $text_id)
    {
        try {
            $text = App\Text::where('id', $text_id)->firstOrFail();
            $text->delete();
        } catch(\Exception $e) {
            $request->session()->flash('status', 'Error!');
        } finally {
            // return redirect('texts');
        }
    }
}