<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefreshController extends Controller
{
    public function redirect($route){
        return $this->redirect(str_replace('_', '.', $route));
    }
}
