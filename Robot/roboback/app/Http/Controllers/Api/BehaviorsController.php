<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App;

class BehaviorsController extends Controller {
    public function show($project_id) {
        try {
            $statusCode = 200;
            $response   = [];
            $project    = App\Project::where('id', $project_id)->firstOrFail();
            $behaviors  = $project->behaviors()->get();

            foreach($behaviors as $behavior) {
                $response[] = [
                    'id'            => $behavior->id,
                    'icon'          => $behavior->icon,
                    'name'          => $behavior->name,
                    'slug'          => $behavior->slug,
                    'language'      => $behavior->language,
                    'behaviortype'  => $behavior->behaviortype,
                    'voicecommands' => $behavior->voicecommands,
                    'sayanimation'  => $behavior->sayanimation
                ];
            }
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            // Log::info('BehaviorsController: Response '.json_encode($response));
            return Response::json($response, $statusCode);
        }
    }

    public function mainmenu($basemenu, $project_id) {
        try {
            $statusCode  = 200;
            $response    = [];
            $menuvisible = true;
            $project     = App\Project::where('id', $project_id)->firstOrFail();
            $behaviors   = App\Behavior::where('basemenu', $basemenu)->get();

            if ($basemenu == 'Dance menu' && $project->bhv_dance_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Greetings menu' && $project->bhv_greetings_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Interaction menu' && $project->bhv_interaction_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Presentation menu' && $project->bhv_presentation_menu == 'false') { $menuvisible = false; };

            if (sizeof($behaviors) == 0) {
                $response[] = [
                   'id'          => 0,
                   'menuvisible' => $menuvisible
                ];
            } else {
                foreach($behaviors as $behavior) {
                      $response[] = [
                        'id'            => $behavior->id,
                        'icon'          => $behavior->icon,
                        'name'          => $behavior->name,
                        'slug'          => $behavior->slug,
                        'language'      => $behavior->language,
                        'behaviortype'  => $behavior->behaviortype,
                        'voicecommands' => $behavior->voicecommands,
                        'sayanimation'  => $behavior->sayanimation,
                        'menuvisible'   => $menuvisible
                    ];
                }
             }
       } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            // Log::info('BehaviorsController: Response '.json_encode($response));
            return Response::json($response, $statusCode);
        }
    }

    public function animation($behavior_id) {
        try {
            $statusCode = 200;
            $response   = [];
            $behavior   = App\Behavior::where('id', $behavior_id)->firstOrFail();
            if ($behavior->sayanimation == "true") {
                $response[] = [
                    'id'            => $behavior->id,
                    'icon'          => $behavior->icon,
                    'name'          => $behavior->name,
                    'slug'          => $behavior->slug,
                    'language'      => $behavior->language,
                    'behaviortype'  => $behavior->behaviortype,
                    'voicecommands' => $behavior->voicecommands,
                    'sayanimation'  => $behavior->sayanimation
                ];
            }
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            // Log::info('BehaviorsController: Response '.json_encode($response));
            return Response::json($response, $statusCode);
        }
    }

}