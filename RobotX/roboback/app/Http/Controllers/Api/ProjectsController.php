<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller {
    public function index() {
        try {
            $statusCode = 200;
            $response = [];
            $projects = App\Project::all();

            foreach($projects as $project) {
                $response[] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'start_time' => $project->start_time,
                    'image' => $project->image,
                    'picture' => $project->picture,
                    'imgtype' => $project->imgtype,
                    'bhv_dance_menu' => $project->bhv_dance_menu,
                    'text_dance_menu' => $project->text_dance_menu,
                    'bhv_greetings_menu' => $project->bhv_greetings_menu,
                    'text_greetings_menu' => $project->text_greetings_menu,
                    'bhv_interaction_menu' => $project->bhv_interaction_menu,
                    'text_interaction_menu' => $project->text_interaction_menu,
                    'bhv_presentation_menu' => $project->bhv_presentation_menu,
                    'text_presentation_menu' => $project->text_presentation_menu
                ];
            }
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            return Response::json($response, $statusCode);
        }
    }
}