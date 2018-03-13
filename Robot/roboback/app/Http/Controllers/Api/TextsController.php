<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App;

class TextsController extends Controller {
    public function show($project_id) {
        try {
            $statusCode = 200;
            $response   = [];
            $project    = App\Project::where('id', $project_id)->firstOrFail();
            $texts      = $project->texts()->get();

            foreach($texts as $text) {
                $response[] = [
                    'id'            => $text->id,
                    'name'          => $text->name,
                    'icon'          => $text->icon,
                    'text'          => $text->text,
                    'language'      => $text->language,
                    'voicecommands' => $text->voicecommands,
                    'animations'    => $text->animations
                ];
            }
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            // Log::info('TextsController: Response '.json_encode($response));
            return Response::json($response, $statusCode);
        }
    }

    public function mainmenu($basemenu, $project_id) {
        try {
            $statusCode  = 200;
            $response    = [];
            $menuvisible = true;
            $project     = App\Project::where('id', $project_id)->firstOrFail();
            $texts       = App\Text::where('basemenu', $basemenu)->get();

            if ($basemenu == 'Dance menu' && $project->text_dance_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Greetings menu' && $project->text_greetings_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Interaction menu' && $project->text_interaction_menu == 'false') { $menuvisible = false; };
            if ($basemenu == 'Presentation menu' && $project->text_presentation_menu == 'false') { $menuvisible = false; };

            if (sizeof($texts) == 0) {
                $response[] = [
                   'id'          => 0,
                   'menuvisible' => $menuvisible
                ];
            } else {
                foreach($texts as $text) {
                    $response[] = [
                        'id'            => $text->id,
                        'name'          => $text->name,
                        'icon'          => $text->icon,
                        'text'          => $text->text,
                        'language'      => $text->language,
                        'voicecommands' => $text->voicecommands,
                        'animations'    => $text->animations,
                        'menuvisible'   => $menuvisible
                    ];
                }
            }
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            return Response::json($response, $statusCode);
        }
    }
}