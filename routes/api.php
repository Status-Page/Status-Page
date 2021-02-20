<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    if($request->user()->tokenCan('read_users')){
        return response(json_encode(array(
            'result' => 'ok',
            'data' => $request->user()
        )), 200);
    }else{
        return response(json_encode(array(
            'result' => 'error',
            'data' => array(
                'message' => 'Not Authorized.'
            )
        )), 403);
    }
});
