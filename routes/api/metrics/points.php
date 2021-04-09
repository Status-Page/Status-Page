<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\MetricPointResource;
use App\Models\Metric;
use App\Models\MetricPoint;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use App\Statuspage\Helper\SPHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    if(SPHelper::isManagedMetric($id)){
        return ResponseGenerator::generateResponse(array(
            'message' => 'This Metric is currently managed by a plugin.'
        ), 423);
    }
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
