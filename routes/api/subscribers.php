<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\ComponentResource;
use App\Http\Resources\SubscriberResource;
use App\Models\Component;
use App\Models\Subscriber;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/subscribers', function (Request $request) {
    if(APIHelpers::hasPermission('read:subscribers', $request)){
        return SubscriberResource::collection(Subscriber::paginate(intval($request->get('per_page', 100))));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::get('/subscribers/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('read:subscribers', $request)){
        return new SubscriberResource(Subscriber::find($id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::post('/subscribers', function (Request $request) {
    if(APIHelpers::hasPermission('add:subscribers', $request)){
        $subscriber = new Subscriber();

        $subscriber->email = $request->get('email');
        $subscriber->email_verified = $request->get('email_verified', false);
        if($subscriber->email_verified){
            $subscriber->email_verified_at = Carbon::now();
        }

        $validator = Validator::make([
            'email' => $subscriber->email,
            'email_verified' => $subscriber->email_verified,
        ], [
            'email' => ['required', 'email', 'min:0', 'max:255', Rule::unique('subscribers', 'email')],
            'email_verified' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(array(
                'errors' => $validator->errors()
            ), 400);
        }

        $subscriber->save();
        $subscriber->generateManageKey();

        return new SubscriberResource(Subscriber::find($subscriber->id));
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});

Route::delete('/subscribers/{id}', function (Request $request, $id) {
    if(APIHelpers::hasPermission('delete:subscribers', $request)){
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return ResponseGenerator::generateEmptyResponse();
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
