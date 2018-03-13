<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class RobotsController extends Controller {

    /**
     * The validation rules for the connections
     */
    public $validations = [
        'name' => 'required',
        'type' => 'required',
    ];

    public function index()
    {
        $robots = App\Robot::orderBy('created_at', 'asc')->get();
        if (sizeof($robots) == 0)
        {
            $rbnew = new App\Robot();
            $rbnew->robots();
            $robots = App\Robot::orderBy('created_at', 'asc')->get();
        }
        return view('robots.index')->withRobots($robots);
    }

    public function link(Request $request, $behavior_id) {
        $robots = App\Robot::pluck('name', 'id');
        // Render view
        return view('robots.link')->withRobots($robots)->withBehaviorId($behavior_id);
    }

    public function savelink(Request $request) {
        // Get the request data as an array
        $data     = $request->all();
        $behavior = App\Project::where('id', $data['behavior_id'])->firstOrFail();

        try
        {
            $behavior->robots()->attach($data['robots']);
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() === 'Undefined index: robots')
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
     * Create an robot
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
//        $behavior_id = $request->get('$behavior_id', false);
//
//        // Render view
//        return view('robots.edit')->withBehaviorId($behavior_id);
        return view('robots.edit');
    }

    /**
     * Create a new robot
     *
     * @param Request $request
     */
    public function store(Request $request) {
        // Validate the request (also check if SQL connection can be established)
        $this->validate($request, $this->validations);

        // Get the request data as an array
        $data = $request->all();
 Log::info('RobotsController: store '.json_encode($data));

        if (isset($data['behavior_id']))
        {
            $behavior_id = $data['behavior_id'];
            unset($data['behavior_id']);
        }

        try
        {
            // Create a new record
            $created_robot = App\Robot::create($data);
            if (isset($behavior_id))
            {
               // $created_robot->behaviors()->attach($behavior_id);
            }
        }
        catch (\Exception $e)
        {
            Log::critical('store Robot: '.$e);
        }
    }

    /**
     * Update an robot
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
        App\Robot::find($id)->update($data);
    }

    /**
     * Edit an robot
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
 Log::info('RobotsController: edit '.json_encode($id));
        $robot = App\Robot::where('id', $id)->firstOrFail();

//        return view('robots.edit')->withIcon($icon);
        return view('robots.edit')->withRobot($robot);
    }

    public function destroy(Request $request, $robot_id)
    {
        try {
            $robot = App\Robot::where('id', $robot_id)->firstOrFail();
            $robot->delete();
        } catch (\Exception $e) {
            $request->session()->flash('status', 'Error!');
        } finally {
            // return redirect('icons');
        }
    }

    /**
     * Get an robot
     *
     * @param $id
     * @return mixed
     */
    public function getrobot(Request $request)
    {
        // Log::info('RobotsController: getrobot $request '.json_encode($request));
        $data  = Input::all();
        $robot = App\Robot::where('id', $data['id'])->firstOrFail();
        return $robot;
    }

    public function show(Request $request)
    {
        Log::info('RobotsController: show $request '.json_encode($request));
    }
}