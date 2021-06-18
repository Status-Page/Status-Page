<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\IncidentUpdateResource;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/incidents/{incident_id}/updates', function (Request $request, $incident_id) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        $incident = Incident::findOrFail($incident_id);
        return IncidentUpdateResource::collection($incident->incidentUpdates()->paginate(intval($request->get('per_page', 100))));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::get('/incidents/{incident_id}/updates/{id}', function (Request $request, $incident_id, $id) {
    if(APIHelpers::hasPermission('read:incidents', $request)){
        $incident = Incident::findOrFail($incident_id);
        return new IncidentUpdateResource($incident->incidentUpdates()->findOrFail($id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::post('/incidents/{id}/updates', function (Request $request, $id) {
    if(APIHelpers::hasPermission('edit:incidents', $request)){
        $incident = Incident::findOrFail($id);
        $incidentUpdate = new IncidentUpdate();

        $incidentUpdate->text = $request->get('message');
        $incidentUpdate->status = $request->get('status', $incident->status);

        $incidentUpdate->incident_id = $incident->id;
        $incidentUpdate->user = $request->user()->id;
        $incidentUpdate->type = $incident->status == $incidentUpdate->status ? 0 : 1;

        if(config('statuspage.migration_mode')){
            $incidentUpdate->updated_at = $request->get('updated_at', Carbon::now());
            $incidentUpdate->created_at = $request->get('created_at', Carbon::now());
        }

        $validator = Validator::make([
            'message' => $incidentUpdate->text,
            'status' => $incidentUpdate->status,
        ], [
            'message' => 'required|string',
            'status' => 'integer|min:0|max:3',
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(array(
                'errors' => $validator->errors()
            ), 400);
        }

        $incidentUpdate->save();
        return new IncidentUpdateResource(IncidentUpdate::find($incidentUpdate->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::delete('/incidents/{id}/updates/{update}', function (Request $request, $id, $update) {
    if(APIHelpers::hasPermission('delete:incidents', $request)){
        $incidentUpdate = IncidentUpdate::findOrFail($update);
        $incidentUpdate->delete();

        return ResponseGenerator::generateEmptyResponse();
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
