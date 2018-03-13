<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Robot;

class BehaviorsController extends Controller
{
    /**
     * The validation rules for the connections
     * @var array
     */
    public $validations = [
        'name' => 'required',
        'slug' => 'required',
    ];
    public $behaviorTypes = [
        'NAO Key Behavior' => 'NAO Key Behavior',
        'Video on Screen'  => 'Video on Screen',
        'Wepage on Screen' => 'Wepage on Screen',
    ];
    public $baseMenus = [
        'Standaard menu'    => 'Standaard menu',
        'Dance menu'        => 'Dance menu',
        'Greetings menu'    => 'Activities menu',
        'Interaction menu'  => 'Interaction menu',
        'Presentation menu' => 'Presentation menu',
    ];
    public $languages = [
        'Dutch'   => 'Dutch',
        'English' => 'English',
        'German'  => 'German',
        'French'  => 'French',
    ];

    public function savevideo(Request $request)
    {
        // Log::info('BehaviorsController: video $request '.json_encode($request));
        $file = Input::file('uploadfile');
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . $file->getClientOriginalName();
        $file->move(public_path() . '/data/', $name);

        return Response::json(['success' => true, 'name' => $name, 'file' => $name], 200);
    }

    public function index()
    {
        $behaviors = App\Behavior::orderBy('name', 'asc')->get();
        $robots    = App\Robot::orderBy('name', 'asc')->get();

        return view('behaviors.index')->withBehaviors($behaviors)->withLanguages($this->languages)->withRobots($robots);
    }

    public function reorder(Request $request, $project_id)
    {
        // Get the request data as an array
        $data = $request->all();

        // Project
        App\Project::where('id', $project_id)->firstOrFail();

        foreach($data['behaviors'] as $order => $behavior_id) {
            App\Behavior::find($behavior_id)->projects()->updateExistingPivot($project_id, ['order' => $order]);
        }
    }

    public function icons(Request $request, $behavior_id) {
        $request->session()->put('INPUTDATA', $request->all());
        $icons = App\Icon::orderBy('name', 'asc')->pluck('name', 'id', 'type', 'icon');
	  //$icons = App\Icon::orderBy('name', 'asc')->get();
	//	$icons->orderBy('name', 'asc');
        $icons->prepend('', '-1');
		
        return view('behaviors.linkicon')->withIcons($icons)->withBehaviorId($request->all()['behavior_id']);
    }

    public function saveicon(Request $request) {
        // Get the request data as an array
        $data = $request->all();
        $input = $request->session()->get('INPUTDATA');

        if ($input['behavior_id'] == 'NEW')
        {
            $behavior = App\Behavior::create($input);
        }
        else
        {
            $behavior = App\Behavior::where('id', $data['behavior_id'])->firstOrFail();
        }
        foreach ($input as $key => $value)
        {
            $behavior->{ $key } = $value;
        }

        try
        {
            $robotnames = App\Robot::pluck('name', 'id');
            if ($data['icon'] != '-1')
            {
                $behavior['icon'] = $data['icon'];
            }
            return view('behaviors.behaviordata')->withBehavior($behavior)->withBehaviorTypes($this->behaviorTypes)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withRobotnames($robotnames);
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() === 'Undefined index: behaviors')
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
        $robotnames = App\Robot::pluck('name', 'id');

        return view('behaviors.behaviordata')->withBehaviorTypes($this->behaviorTypes)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withRobotnames($robotnames);
    }

    /**
     * Create a new behavior
     * @param Request $request
     */
    public function store(Request $request) {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();
        $data['language'] = implode(' ', $data['languages']);

        if (isset($data['project_id']))
        {
            $project_id = @$data['project_id'];
            unset($data['project_id']);
        }

        try
        {
            // Create a new revord
            $created_behavior = App\Behavior::create($data);
            if (isset($project_id)) {
                $created_behavior->projects()->attach($project_id);
            }
        }
        catch (\Exception $e)
        {
            Log::critical('store behavior: '.$e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link(Request $request, $project_id)
    {
        $allbehavs = App\Behavior::pluck('name', 'id');
        $project   = App\Project::where('id', $project_id)->firstOrFail();
        $ids       = $project->behaviors()->pluck('id');
        $behaviors = $allbehavs->filter(function ($value, $key) use ($ids) {
            return !$ids->contains($key);
        });

        // Render view
        return view('behaviors.link')->withBehaviors($behaviors)->withProjectId($project_id);
    }

    public function savelink(Request $request)
    {
         // Get the request data as an array
        $data = $request->all();
        $prj  = App\Project::where('id', $data['project_id'])->firstOrFail();

        try
        {
            $prj->behaviors()->attach($data['behaviors']);
            $project = App\Project::where('id', $data['project_id'])->firstOrFail();
            foreach ($data['behaviors'] as $bhv)
            {
                App\Behavior::find($bhv)->projects()->updateExistingPivot($project->id, ['order' => sizeof($project->behaviors) + 1]);
            }
        }
        catch (\Exception $e)
        {
            Log::critical('savelink: '.$e);
            if ($e->getMessage() === 'Undefined index: behaviors')
            {
                return 'EMPTY INPUT';
            }
            if (strpos($e->getMessage(), 'Duplicate entry') !== false)
            {
                return 'DUPLICATE ENTRY';
            }
            if ($e->getMessage() === 'Undefined index: behaviors')
            {
            }
            return "Exception: " . $e->getMessage();
        }
    }

    /**
     * Edit a behavior
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $behavior = App\Behavior::where('id', $id)->firstOrFail();
        $behavior['languages'] = explode(' ', $behavior['language']);
        // Log::info('BehaviorsController: edit $behavior '.json_encode($behavior));

        $robotnames = App\Robot::pluck('name', 'id');
        // Log::info('BehaviorsController: $robotnames '.json_encode($robotnames));

        return view('behaviors.behaviordata')->withBehavior($behavior)->withBehaviorTypes($this->behaviorTypes)->withBaseMenus($this->baseMenus)->withLanguages($this->languages)->withRobotnames($robotnames);
    }

    public function update(Request $request, $id)
    {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();
        if (isset($data['languages'])) {
            $data['language'] = implode(' ', $data['languages']);
        } else {
            $data['language'] = 'Dutch';
        }
        if(!isset($data['sayanimation'])) {
            $data['sayanimation'] = 'false';
        }

        // Update the connection with the new information
        $bhv = App\Behavior::find($id);
        $bhv->update($data);
        // unset($data['robot_version'][0]);
        if (isset($data['robot_version'])) {
            $bhv->robots()->sync($data['robot_version']);
        }
    }

    public function destroy(Request $request, $behavior_id)
    {
        try {
            $behavior = App\Behavior::where('id', $behavior_id)->firstOrFail();
            $behavior->delete();
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        }
    }

}