<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function actionLog(Request $request){
        return view('dashboard.admin.actionlog', [
            'logs' => Action::query()->orderBy('id', 'desc')->paginate($request->get('per_page', '20'))
        ]);
    }

    public function users(Request $request){
        return view('dashboard.admin.actionlog', [
            'logs' => Action::query()->orderBy('id', 'desc')->paginate($request->get('per_page', '20'))
        ]);
    }
}
