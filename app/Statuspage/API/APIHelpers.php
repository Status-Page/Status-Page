<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage\API;


use Illuminate\Http\Request;

class APIHelpers
{
    public static function hasPermission($permission, Request $request){
        return $request->user()->tokenCan($permission) && $request->user()->can(str_replace(':', '_', $permission));
    }
}
