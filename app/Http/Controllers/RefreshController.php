<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Controllers;

class RefreshController extends Controller
{
    public function redirect($route){
        return $this->redirect(str_replace('_', '.', $route));
    }
}
