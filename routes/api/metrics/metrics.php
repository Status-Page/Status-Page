<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\MetricResource;
use App\Models\Metric;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/metrics', function (Request $request) {
    if(APIHelpers::hasPermission('read:metrics', $request)){
        return MetricResource::collection(Metric::paginate(intval($request->get('per_page', 100))));
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
        $metric->suffix = $request->get('suffix', '');
        $metric->order = $request->get('order', 0);
        $metric->visibility = $request->get('visibility', 0);

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

        $metric->title = $request->get('title', $metric->title);
        $metric->suffix = $request->get('suffix', $metric->suffix);
        $metric->order = $request->get('order', $metric->order);
        $metric->visibility = $request->get('visibility', $metric->visibility);

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
