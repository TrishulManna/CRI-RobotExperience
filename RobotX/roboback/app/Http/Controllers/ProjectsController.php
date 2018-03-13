<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ProjectsController extends Controller
{
    /**
     * The validation rules for the connections
     * @var array
     */
    public $validations = [
        'name' => 'required',
        'start_time' => 'required',
    ];

    public function image(Request $request)
    {
        $file = Input::file('uploadfile');
//        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
//        $name = $timestamp . '-' . $file->getClientOriginalName();
//        $file->move(public_path() . '/data/', $name);
        $img_data = file_get_contents($file);
        $base64   = base64_encode($img_data);
        $type     = $file->getClientOriginalExtension();
        $mime     = $file->getMimeType();
        $size     = $file->getSize();
        $name     = $file->getClientOriginalName();

        return Response::json(['success' => true, 'name' => $name, 'file' => $name, 'imgtype' => $type, 'picture' => $base64], 200);
    }

    public function index()
    {
        $projects = App\Project::orderBy('start_time', 'asc')->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        // Render view
        return view('projects.projectdata');
    }

    public function change(Request $request, $project_id)
    {
        $project = App\Project::where('id', $project_id)->firstOrFail();
        $project->start_time = date('d-m-Y H:i', strtotime($project->start_time));

        // Render view
//        return view('projects.changeinfo')->withProject($project);
        return view('projects.projectdata')->withProject($project);
    }

    /**
     * Create a new project
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();

        $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['start_time']));

        // Create a new connection
        $created_project = App\Project::create($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);
        // Log::info('ProjectsController: update $request '.json_encode($request));

        // Get the request data as an array
        $data = $request->all();
        $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['start_time']));

        if(empty($data['image'])) {
            unset($data['image']);
        }
        if(!isset($data['bhv_dance_menu'])) {
            $data['bhv_dance_menu'] = 'false';
        }
        if(!isset($data['text_dance_menu'])) {
            $data['text_dance_menu'] = 'false';
        }
        if(!isset($data['bhv_greetings_menu'])) {
            $data['bhv_greetings_menu'] = 'false';
        }
        if(!isset($data['text_greetings_menu'])) {
            $data['text_greetings_menu'] = 'false';
        }
        if(!isset($data['bhv_interaction_menu'])) {
            $data['bhv_interaction_menu'] = 'false';
        }
        if(!isset($data['text_interaction_menu'])) {
            $data['text_interaction_menu'] = 'false';
        }
        if(!isset($data['bhv_presentation_menu'])) {
            $data['bhv_presentation_menu'] = 'false';
        }
        if(!isset($data['text_presentation_menu'])) {
            $data['text_presentation_menu'] = 'false';
        }

        // Update the connection with the new information
        App\Project::find($id)->update($data);
    }

    /**
     * Edit a connection
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $project = App\Project::where('id', $id)->firstOrFail();

        return view('projects.edit')->withProject($project);
    }

    /**
     * Edit the project in a page
     *
     * @param $id   project id
     * @return mixed
     */
    public function projectdata($id)
    {
        $project = App\Project::where('id', $id)->firstOrFail();

        return view('projects.projectdata')->withProject($project);
    }

    public function copy($id)
    {
        // Log::info('ProjectsController: Copy $id '.json_encode($id));
        $project = App\Project::where('id', $id)->firstOrFail();

        $data = $project->copy();

        // Create the new project
        $created_project = App\Project::create($data);
        // Log::info('ProjectsController: Copy $created_project '.json_encode($created_project));

        // Add the texts to the new project
        foreach ($project->texts as $value) {
            $created_project->texts()->attach($value);
        }
        // Set the texts in the correct order
        foreach($project->texts as $order => $text) {
            $text->projects()->updateExistingPivot($created_project['id'], ['order' => $order]);
        }
        foreach ($project->behaviors as $value) {
            $created_project->behaviors()->attach($value);
        }
        // Set the behaviors in the correct order
        foreach($project->behaviors as $order => $behavior) {
            $behavior->projects()->updateExistingPivot($created_project['id'], ['order' => $order]);
        }

        return redirect('projects');
    }

    public function destroy(Request $request, $project_id)
    {
        try {
            $project = App\Project::where('id', $project_id)->firstOrFail();
            // unlink(public_path() . '/data/' . $project->image);
            foreach ($project->texts as $value) {
                $project->texts()->detach($value['id']);
            }
            foreach ($project->behaviors as $value) {
                $project->behaviors()->detach($value['id']);
            }
            $project->delete();
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        } finally {
            return redirect('projects');
        }
    }

    public function deleteBehavior(Request $request, $behavior_id, $project_id)
    {
        try {
            $project = App\Project::where('id', $project_id)->firstOrFail();
            $project->behaviors()->detach($behavior_id);
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        }
    }

    public function deleteText(Request $request, $text_id, $project_id)
    {
        try {
            $project = App\Project::where('id', $project_id)->firstOrFail();
            $project->texts()->detach($text_id);
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        }
    }
}