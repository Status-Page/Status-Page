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

Route::get('/maintenances', function (Request $request) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        return IncidentResource::collection(Incident::query()->where([['type', 1]])->paginate(intval($request->get('per_page', 100))));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::get('/maintenances/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        return new IncidentResource(Incident::find($id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::post('/maintenances', function (Request $request) {
    if(APIHelpers::hasPermission('edit:incidents', $request)){
        $incident = new Incident();

        $incident->title = $request->get('title');
        $incident->status = $request->get('status', 0);
        $incident->visibility = $request->get('visibility', false);
        $incident->scheduled_at = $request->get('scheduled_at');
        $incident->end_at = $request->get('end_at');
        $components = $request->get('components', []);
        $message = $request->get('message');

        $incident->user = $request->user()->id;
        $incident->type = 1;
        $incident->impact = 4;

        $validator = Validator::make([
            'title' => $incident->title,
            'status' => $incident->status,
            'visibility' => $incident->visibility,
            'scheduled_at' => $incident->scheduled_at,
            'end_at' => $incident->end_at,
            'components' => $components,
            'message' => $message,
        ], [
            'title' => 'required|string|min:3',
            'status' => 'integer|min:0|max:3',
            'visibility' => 'boolean',
            'scheduled_at' => 'required|date|after:'.Carbon::now(),
            'end_at' => 'nullable|date',
            'components' => 'array',
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
        return new IncidentResource(Incident::find($incident->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::match(['patch', 'put'], '/maintenances/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('edit:incidents', $request)){
        $incident = Incident::findOrFail($id);

        $incident->title = $request->get('title', $incident->title);
        $incident->status = $request->get('status', $incident->status);
        $incident->visibility = $request->get('visibility', $incident->visibility);
        $incident->scheduled_at = $request->get('scheduled_at', $incident->scheduled_at);
        $incident->end_at = $request->get('end_at', $incident->end_at);
        $components = $request->get('components', $incident->components()->get()->map(function ($component){
            return $component->id;
        })->toArray());

        $validator = Validator::make([
            'title' => $incident->title,
            'status' => $incident->status,
            'visibility' => $incident->visibility,
            'scheduled_at' => $incident->scheduled_at,
            'end_at' => $incident->end_at,
            'components' => $components,
        ], [
            'title' => 'required|string|min:3',
            'status' => 'integer|min:0|max:3',
            'visibility' => 'boolean',
            'scheduled_at' => 'date|after:'.Carbon::now(),
            'end_at' => 'nullable|date',
            'components' => 'array',
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

        return new IncidentResource(Incident::find($incident->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::delete('/maintenances/{id}', function (Request $request, $id) {
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
