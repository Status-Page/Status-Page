<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Models\Component;
use App\Models\Status;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/ping', function (Request $request) {
        return ResponseGenerator::generateEmptyResponse();
    });

    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/user', function (Request $request) {
            if(APIHelpers::hasPermission('read:users', $request)){
                return ResponseGenerator::generateResponse($request->user());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::get('/components', function (Request $request) {
            if(APIHelpers::hasPermission('read:components', $request)){
                return ResponseGenerator::generateResponse(Component::all());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::get('/components/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('read:components', $request)){
                return ResponseGenerator::generateResponse(Component::find($id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::post('/components', function (Request $request) {
            if(APIHelpers::hasPermission('edit:components', $request)){
                $component = new Component();

                $component->name = $request->get('name');
                $component->link = $request->get('link');
                $component->group = $request->get('group');
                $component->visibility = $request->get('visibility') ?: false;
                $component->status_id = $request->get('status_id') ?: 1;
                $component->order = $request->get('order') ?: 0;

                $component->user = $request->user()->id;

                $validator = Validator::make([
                    'name' => $component->name,
                    'link' => $component->link,
                    'group' => $component->group,
                    'visibility' => $component->visibility,
                    'status_id' => $component->status_id,
                    'order' => $component->order,
                ], [
                    'name' => 'required|string|min:3',
                    'link' => 'nullable|url',
                    'group' => 'required|integer|min:1',
                    'visibility' => 'boolean',
                    'status_id' => 'integer|min:1|max:6',
                    'order' => 'integer',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $component->save();
                $component->refresh();
                return ResponseGenerator::generateResponse($component);
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::put('/components/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:components', $request)){
                $component = Component::findOrFail($id);

                $component->name = $request->get('name') ?: $component->name;
                $component->link = $request->get('link') ?: $component->link;
                $component->group = $request->get('group') ?: $component->group;
                $component->visibility = $request->get('visibility') ?: $component->visibility;
                $component->status_id = $request->get('status_id') ?: $component->status_id;
                $component->order = $request->get('order') ?: $component->order;

                $validator = Validator::make([
                    'name' => $component->name,
                    'link' => $component->link,
                    'group' => $component->group,
                    'visibility' => $component->visibility,
                    'status_id' => $component->status_id,
                    'order' => $component->order,
                ], [
                    'name' => 'required|string|min:3',
                    'link' => 'nullable|url',
                    'group' => 'required|integer|min:1',
                    'visibility' => 'boolean',
                    'status_id' => 'integer|min:1|max:6',
                    'order' => 'integer',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $component->save();
                $component->refresh();
                return ResponseGenerator::generateResponse($component);
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::delete('/components/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('delete:components', $request)){
                $component = Component::findOrFail($id);
                $component->delete();

                return ResponseGenerator::generateEmptyResponse();
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });



        Route::get('/status', function (Request $request) {
            if(APIHelpers::hasPermission('read:statuses', $request)){
                return ResponseGenerator::generateResponse(Status::all());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });
    });
});
