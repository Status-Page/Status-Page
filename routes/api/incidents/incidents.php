<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\IncidentResource;
use App\Models\Incident;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/incidents', function (Request $request) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        return IncidentResource::collection(Incident::query()->where([['type', 0]])->paginate(intval($request->get('per_page', 100))));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::get('/incidents/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        return new IncidentResource(Incident::find($id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::post('/incidents', function (Request $request) {
    if(APIHelpers::hasPermission('edit:incidents', $request)){
        $incident = new Incident();

        $incident->title = $request->get('title');
        $incident->status = $request->get('status', 0);
        $incident->impact = $request->get('impact', 0);
        $incident->visibility = $request->get('visibility', false);
        $components = $request->get('components', []);
        $component_status = $request->get('component_status', 0);
        $message = $request->get('message');

        $incident->user = $request->user()->id;
        $incident->type = 0;


        $validator = Validator::make([
            'title' => $incident->title,
            'status' => $incident->status,
            'impact' => $incident->impact,
            'visibility' => $incident->visibility,
            'components' => $components,
            'component_status' => $component_status,
            'message' => $message,
        ], [
            'title' => 'required|string|min:3',
            'status' => 'integer|min:0|max:3',
            'impact' => 'integer|min:0|max:3',
            'visibility' => 'boolean',
            'components' => 'array',
            'component_status' => 'integer|min:0|max:5',
            'message' => 'required|string',
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(array(
                'errors' => $validator->errors()
            ), 400);
        }

        $incident->save();
        $incident->refresh();
        $incident->incidentUpdates()->insert([
            'incident_id' => $incident->id,
            'type' => 1,
            'text' => $message,
            'status' => $incident->status,
            'user' => $incident->user,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
        $incident->components()->attach($components);
        if($component_status != 0){
            $incident->components()->update([
                'status_id' => $component_status
            ]);
        }
        return new IncidentResource(Incident::find($incident->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::match(['patch', 'put'], '/incidents/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('edit:incidents', $request)){
        $incident = Incident::findOrFail($id);

        $incident->title = $request->get('title', $incident->title);
        $incident->status = $request->get('status', $incident->status);
        $incident->impact = $request->get('impact', $incident->impact);
        $incident->visibility = $request->get('visibility', $incident->visibility);
        $components = $request->get('components', $incident->components()->get()->map(function ($component){
            return $component->id;
        })->toArray());
        $component_status = $request->get('component_status', 0);

        $validator = Validator::make([
            'title' => $incident->title,
            'status' => $incident->status,
            'impact' => $incident->impact,
            'visibility' => $incident->visibility,
            'components' => $components,
            'component_status' => $component_status,
        ], [
            'title' => 'string|min:3',
            'status' => 'integer|min:0|max:3',
            'impact' => 'integer|min:0|max:3',
            'visibility' => 'boolean',
            'components' => 'array',
            'component_status' => 'integer|min:0|max:5',
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(array(
                'errors' => $validator->errors()
            ), 400);
        }

        $incident->save();
        $incident->refresh();

        $incident->components()->detach();
        $incident->components()->attach($components);
        if($component_status != 0){
            $incident->components()->update([
                'status_id' => $component_status
            ]);
        }

        return new IncidentResource(Incident::find($incident->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::delete('/incidents/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('delete:incidents', $request)){
        $incident = Incident::findOrFail($id);
        $incident->delete();

        return ResponseGenerator::generateEmptyResponse();
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
