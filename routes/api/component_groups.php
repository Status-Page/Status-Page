<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\ComponentGroupResource;
use App\Models\ComponentGroup;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/component-groups', function (Request $request) {
    if(APIHelpers::hasPermission('read:componentgroups', $request)){
        return ComponentGroupResource::collection(ComponentGroup::paginate(intval($request->get('per_page', 100))));
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
        $component->description = $request->get('description', '');
        $component->visibility = $request->get('visibility', false);
        $component->order = $request->get('order', 0);
        $component->collapse = $request->get('collapse', 'expand_issue');

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

        $component->name = $request->get('name', $component->name);
        $component->description = $request->get('description', $component->description);
        $component->visibility = $request->get('visibility', $component->visibility);
        $component->order = $request->get('order', $component->order);
        $component->collapse = $request->get('collapse', $component->collapse);

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
