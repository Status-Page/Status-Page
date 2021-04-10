<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage;


use Illuminate\Support\Facades\Http;

class Version
{
    public static function getVersion(){
        return 'v1.6.5';
    }

    public static function getLatestVersion() {
        return json_decode(Http::get(route('api.version'))->body());
    }
}
