<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage\API;


class ResponseGenerator
{
    public static function generateEmptyResponse($code = 204){
        return response(null, $code, [
            'Content-Type' => 'application/json'
        ]);
    }

    public static function generateResponse($data, $code = 200){
        return response(json_encode(array(
            'data' => $data
        )), $code, [
            'Content-Type' => 'application/json'
        ]);
    }
}
