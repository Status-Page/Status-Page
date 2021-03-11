<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\ComponentGroupResource;
use App\Http\Resources\ComponentResource;
use App\Http\Resources\MetricPointResource;
use App\Http\Resources\MetricResource;
use App\Http\Resources\StatusResource;
use App\Models\Component;
use App\Models\ComponentGroup;
use App\Models\Metric;
use App\Models\MetricPoint;
use App\Models\Status;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use App\Statuspage\GlobalConfig;
use App\Statuspage\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
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
        $lasttag = config('app.url') == 'https://status.herrtxbias.me' ?: \Illuminate\Support\Facades\Http::get('https://status.herrtxbias.me/api/v1/version');
        $formatted_lasttag = config('app.url') == 'https://status.herrtxbias.me' ? Version::getVersion() : $lasttag->json()->data;

        return ResponseGenerator::generateMetaResponse(Version::getVersion(), array(
            'on_latest' => Version::getVersion() == $formatted_lasttag,
            'git' => array(
                'tag' => Version::getVersion(),
                'last_tag' => $formatted_lasttag
            )
        ));
    })->name('api.version');

    Route::middleware('auth:sanctum')->group(function (){
        /*
         * |---------------------------------------------
         * |    ConfigCat PageID
         * |---------------------------------------------
         */
        Route::get('/configcat_pageid', function (Request $request) {
            if(APIHelpers::hasPermission('configcat_pageid', $request)){
                return ResponseGenerator::generateResponse(GlobalConfig::uniquePageID());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

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
                $component->description = $request->get('description') ?: "";
                $component->group = $request->get('group');
                $component->visibility = $request->get('visibility') ?: false;
                $component->status_id = $request->get('status_id') ?: 1;
                $component->order = $request->get('order') ?: 0;

                $component->user = $request->user()->id;

                $validator = Validator::make([
                    'name' => $component->name,
                    'link' => $component->link,
                    'description' => $component->description,
                    'group' => $component->group,
                    'visibility' => $component->visibility,
                    'status_id' => $component->status_id,
                    'order' => $component->order,
                ], [
                    'name' => 'required|string|min:3',
                    'link' => 'nullable|url',
                    'description' => 'string|min:3',
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

        Route::match(['patch', 'put'], '/components/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:components', $request)){
                $component = Component::findOrFail($id);

                $component->name = $request->get('name') ?: $component->name;
                $component->link = $request->get('link') ?: $component->link;
                $component->description = $request->get('description') ?: $component->description;
                $component->group = $request->get('group') ?: $component->group;
                $component->visibility = $request->get('visibility') ?: $component->visibility;
                $component->status_id = $request->get('status_id') ?: $component->status_id;
                $component->order = $request->get('order') ?: $component->order;

                $validator = Validator::make([
                    'name' => $component->name,
                    'link' => $component->link,
                    'description' => $component->description,
                    'group' => $component->group,
                    'visibility' => $component->visibility,
                    'status_id' => $component->status_id,
                    'order' => $component->order,
                ], [
                    'name' => 'string|min:3',
                    'link' => 'nullable|url',
                    'description' => 'string|min:3',
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
                $component->description = $request->get('description') ?: '';
                $component->visibility = $request->get('visibility') ?: false;
                $component->order = $request->get('order') ?: 0;
                $component->collapse = $request->get('collapse') ?: 'expand_issue';

                $component->user = $request->user()->id;


                $validator = Validator::make([
                    'name' => $component->name,
                    'description' => $component->description,
                    'visibility' => $component->visibility,
                    'order' => $component->order,
                    'collapse' => $component->collapse,
                ], [
                    'name' => 'required|string|min:3',
                    'description' => 'string|min:3',
                    'visibility' => 'boolean',
                    'order' => 'integer',
                    'collapse' => ['string', Rule::in(['expand_always', 'expand_issue'])],
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

        Route::match(['patch', 'put'], '/component-groups/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:componentgroups', $request)){
                $component = ComponentGroup::findOrFail($id);

                $component->name = $request->get('name') ?: $component->name;
                $component->description = $request->get('description') ?: $component->description;
                $component->visibility = $request->get('visibility') ?: $component->visibility;
                $component->order = $request->get('order') ?: $component->order;
                $component->collapse = $request->get('collapse') ?: $component->collapse;

                $validator = Validator::make([
                    'name' => $component->name,
                    'description' => $component->description,
                    'visibility' => $component->visibility,
                    'order' => $component->order,
                    'collapse' => $component->collapse,
                ], [
                    'name' => 'string|min:3',
                    'description' => 'string|min:3',
                    'visibility' => 'boolean',
                    'order' => 'integer',
                    'collapse' => ['string', Rule::in(['expand_always', 'expand_issue'])],
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
         * |    Metrics
         * |---------------------------------------------
         */
        Route::get('/metrics', function (Request $request) {
            if(APIHelpers::hasPermission('read:metrics', $request)){
                return MetricResource::collection(Metric::paginate(intval($request->get('per_page', 20))));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::get('/metrics/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('read:metrics', $request)){
                return new MetricResource(Metric::find($id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::post('/metrics', function (Request $request) {
            if(APIHelpers::hasPermission('edit:metrics', $request)){
                $metric = new Metric();

                $metric->title = $request->get('title');
                $metric->suffix = $request->get('suffix') ?: '';
                $metric->order = $request->get('order') ?: 0;
                $metric->visibility = $request->get('visibility') ?: 0;

                $validator = Validator::make([
                    'title' => $metric->title,
                    'suffix' => $metric->suffix,
                    'order' => $metric->order,
                    'visibility' => $metric->visibility,
                ], [
                    'title' => 'required|string|min:3',
                    'suffix' => 'string',
                    'order' => 'integer',
                    'visibility' => 'boolean',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $metric->save();
                return new MetricResource(Metric::find($metric->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::match(['patch', 'put'], '/metrics/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:metrics', $request)){
                $metric = Metric::findOrFail($id);

                $metric->title = $request->get('title') ?: $metric->title;
                $metric->suffix = $request->get('suffix') ?: $metric->suffix;
                $metric->order = $request->get('order') ?: $metric->order;
                $metric->visibility = $request->get('visibility') ?: $metric->visibility;

                $validator = Validator::make([
                    'title' => $metric->title,
                    'suffix' => $metric->suffix,
                    'order' => $metric->order,
                    'visibility' => $metric->visibility,
                ], [
                    'title' => 'string|min:3',
                    'suffix' => 'string',
                    'order' => 'integer',
                    'visibility' => 'boolean',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $metric->save();
                return new MetricResource(Metric::find($metric->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::delete('/metrics/{id}', function (Request $request, $id) {
            if(APIHelpers::hasPermission('delete:metrics', $request)){
                $metric = Metric::findOrFail($id);
                $metric->delete();

                return ResponseGenerator::generateEmptyResponse();
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });


        /*
         * |---------------------------------------------
         * |    Metric Points
         * |---------------------------------------------
         */
        Route::get('/metrics/{id}/points', function (Request $request, $id) {
            if(APIHelpers::hasPermission('read:metric_points', $request)){
                return new MetricPointResource(Metric::find($id)->points()->paginate());
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::post('/metrics/{id}/points', function (Request $request, $id) {
            if(APIHelpers::hasPermission('edit:metric_points', $request)){
                $metric = Metric::findOrFail($id);
                $point = new MetricPoint();
                $point->metric_id = $metric->id;

                $point->value = doubleval($request->get('value'));

                $validator = Validator::make([
                    'value' => $point->value,
                ], [
                    'value' => 'required|numeric',
                ]);

                if($validator->fails()){
                    return ResponseGenerator::generateResponse(array(
                        'errors' => $validator->errors()
                    ), 400);
                }

                $point->save();
                return new MetricPointResource(MetricPoint::find($point->id));
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::delete('/metrics/{metric_id}/points/{id}', function (Request $request, $metric_id, $id) {
            if(APIHelpers::hasPermission('delete:metric_points', $request)){
                /**
                 * @var $metric Metric
                 */
                $metric = Metric::findOrFail($metric_id);
                $metric->points()->findOrFail($id)->delete();

                return ResponseGenerator::generateEmptyResponse();
            }else{
                return ResponseGenerator::generateResponse(array(
                    'message' => 'Not Authorized.'
                ), 403);
            }
        });

        Route::delete('/metrics/{metric_id}/points', function (Request $request, $metric_id) {
            if(APIHelpers::hasPermission('delete:metric_points', $request)){
                /**
                 * @var $metric Metric
                 */
                $metric = Metric::findOrFail($metric_id);
                $metric->points()->delete();

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
