<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App;

class IconsController extends Controller {
    public function show($icon_id) {
        try {
            $statusCode = 200;
            $response   = [];
            $icon       = App\Icon::where('id', $icon_id)->firstOrFail();

            $response[] = [
                'name' => $icon->name,
                'icon' => $icon->icon,
                'type' => $icon->type
            ];
        } catch(Exception $e) {
            $statusCode = 400;
        } finally {
            return Response::json($response, $statusCode);
        }
    }
}