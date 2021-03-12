<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function (Request $request) {
    if(APIHelpers::hasPermission('read:statuses', $request)){
        return StatusResource::collection(Status::all());
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
