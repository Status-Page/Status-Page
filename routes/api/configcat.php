<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Statuspage\API\APIHelpers;
use App\Statuspage\API\ResponseGenerator;
use App\Statuspage\GlobalConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/configcat_pageid', function (Request $request) {
    if($request->user()->getRoleNames()->first() == 'super_admin'){
        return ResponseGenerator::generateResponse(GlobalConfig::uniquePageID());
    }else{
        return ResponseGenerator::generateResponse(array(
            'message' => 'Not Authorized.'
        ), 403);
    }
});
