<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\ComponentGroupCollection;
use App\Http\Resources\ComponentGroupResource;
use App\Http\Resources\ComponentResource;
use App\Http\Resources\StatusResource;
use App\Models\Component;
use App\Models\ComponentGroup;
use App\Models\Status;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use App\Statuspage\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
    /*
     * |---------------------------------------------
     * |    General
     * |---------------------------------------------
     */
    Route::get('/ping', function (Request $request) {
        return ResponseGenerator::generateResponse(array(
            'message' => 'Pong!'
        ));
    });

    Route::get('/version', function (Request $request) {
        $tag = Process::fromShellCommandline('git describe --tags');
        $tag->run();
        if (!$tag->isSuccessful()) {
            throw new ProcessFailedException($tag);
        }

        $lasttag = Process::fromShellCommandline('git describe --tags `git rev-list --tags --max-count=1`');
        $lasttag->run();
        if (!$lasttag->isSuccessful()) {
            throw new ProcessFailedException($lasttag);
        }

        $formatted_tag = str_replace("\n", "", $tag->getOutput());
        $formatted_lasttag = str_replace("\n", "", $lasttag->getOutput());

        return ResponseGenerator::generateMetaResponse(Version::getVersion(), array(
            'on_latest' => $formatted_tag == $formatted_lasttag,
            'git' => array(
                'tag' => $formatted_tag,
                'last_tag' => $formatted_lasttag
            )
        ));
    })->name('api.version');

    Route::middleware('auth:sanctum')->group(function (){
        /*
         * |---------------------------------------------
         * |    User
         * |---------------------------------------------
         */
        Route::get('/user', function (Request $request) {
            if(APIHelpers::hasPermission('read:users', $request)){
                return ResponseGenerator::generateResponse($request->user());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        /*
         * |---------------------------------------------
         * |    Components
         * |---------------------------------------------
         */
        Route::get('/components', function (Request $request) {
            if(APIHelpers::hasPermission('read:components', $request)){
                return ComponentResource::collection(Component::paginate(intval($request->get('per_page', 20))));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::get('/components/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('read:components', $request)){
                return new ComponentResource(Component::find($id));
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
                return new ComponentResource(Component::find($component->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::patch('/components/{id}', function (Request $request, $id) {
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
                    'name' => 'string|min:3',
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
                return new ComponentResource(Component::find($id));
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

        /*
         * |---------------------------------------------
         * |    Component Groups
         * |---------------------------------------------
         */
        Route::get('/component-groups', function (Request $request) {
            if(APIHelpers::hasPermission('read:componentgroups', $request)){
                return ComponentGroupResource::collection(ComponentGroup::paginate(intval($request->get('per_page', 20))));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::get('/component-groups/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('read:componentgroups', $request)){
                return new ComponentGroupResource(ComponentGroup::find($id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::post('/component-groups', function (Request $request) {
            if(APIHelpers::hasPermission('edit:componentgroups', $request)){
                $component = new ComponentGroup();

                $component->name = $request->get('name');
                $component->visibility = $request->get('visibility') ?: false;
                $component->order = $request->get('order') ?: 0;

                $component->user = $request->user()->id;


                $validator = Validator::make([
                    'name' => $component->name,
                    'visibility' => $component->visibility,
                    'order' => $component->order,
                ], [
                    'name' => 'required|string|min:3',
                    'visibility' => 'boolean',
                    'order' => 'integer',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $component->save();
                return new ComponentGroupResource(ComponentGroup::find($component->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::patch('/component-groups/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:componentgroups', $request)){
                $component = ComponentGroup::findOrFail($id);

                $component->name = $request->get('name') ?: $component->name;
                $component->visibility = $request->get('visibility') ?: $component->visibility;
                $component->order = $request->get('order') ?: $component->order;

                $validator = Validator::make([
                    'name' => $component->name,
                    'visibility' => $component->visibility,
                    'order' => $component->order,
                ], [
                    'name' => 'string|min:3',
                    'visibility' => 'boolean',
                    'order' => 'integer',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $component->save();
                return new ComponentGroupResource(ComponentGroup::find($component->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::delete('/component-groups/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('delete:componentgroups', $request)){
                $component = ComponentGroup::findOrFail($id);
                $component->delete();

                return ResponseGenerator::generateEmptyResponse();
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });


        /*
         * |---------------------------------------------
         * |    Statuses
         * |---------------------------------------------
         */
        Route::get('/status', function (Request $request) {
            if(APIHelpers::hasPermission('read:statuses', $request)){
                return StatusResource::collection(Status::all());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });
    });
});
