<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function actionLog(){
        return view('dashboard.admin.actionlog');
    }
}
