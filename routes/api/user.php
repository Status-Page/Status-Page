<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    if(APIHelpers::hasPermission('read:users', $request)){
        return ResponseGenerator::generateResponse($request->user());
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
