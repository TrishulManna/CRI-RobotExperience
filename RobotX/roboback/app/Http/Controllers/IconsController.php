<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class IconsController extends Controller {

    /**
     * The validation rules for the connections
     */
    public $validations = [
        'name' => 'required',
        'type' => 'required',
        'icon' => 'required',
    ];


    public function saveIcon(Request $request)
    {
        // Log::info('IconsController: saveIcon $request '.json_encode($request));
        $file     = Input::file('uploadfile');
        $img_data = file_get_contents($file);
        $base64   = base64_encode($img_data);
        $type     = $file->getClientOriginalExtension();
        $mime     = $file->getMimeType();
        $size     = $file->getSize();
        $name     = $file->getClientOriginalName();

        return Response::json(['success' => true, 'name' => $name, 'type' => $type, 'file' => $base64], 200);
    }

    public function index()
    {
        $icons = App\Icon::orderBy('name', 'asc')->get();
        return view('icons.index')->withIcons($icons);
    }

    public function link(Request $request, $project_id) {
        $icons = App\Icon::pluck('name', 'id');
        // Render view
        return view('icons.link')->withIcons($icons)->withProjectId($project_id);
    }

    public function savelink(Request $request) {
        // Get the request data as an array
        $data    = $request->all();
        $project = App\Project::where('id', $data['project_id'])->firstOrFail();

        try
        {
            $project->icons()->attach($data['icons']);
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() === 'Undefined index: icons')
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
     * Create an icon
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
        $project_id = $request->get('project_id', false);

        // Render view
        return view('icons.edit')->withProjectId($project_id);
    }

    /**
     * Create a new icon
     *
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
            $created_icon = App\Icon::create($data);
            if (isset($project_id))
            {
               $created_icon->projects()->attach($project_id);
            }
        }
        catch (\Exception $e)
        {
            Log::critical('store icon: '.$e);
        }
    }

    /**
     * Update an icon
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id) {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();

        // Update the connection with the new information
        App\Icon::find($id)->update($data);
    }

    /**
     * Edit an icon
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $icon = App\Icon::where('id', $id)->firstOrFail();

        return view('icons.edit')->withIcon($icon);
    }

    public function destroy(Request $request, $icon_id)
    {
        try {
            $icon = App\Icon::where('id', $icon_id)->firstOrFail();
            $icon->delete();
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        } finally {
            // return redirect('icons');
        }
    }

    /**
     * Get an icon
     *
     * @param $id
     * @return mixed
     */
    public function icon($id)
    {
        $icon = App\Icon::where('id', $id)->firstOrFail();

        return $icon;
    }
}