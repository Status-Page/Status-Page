<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Controllers;

use App\Models\ComponentGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardComponentController extends Controller
{
    /**
     * Displays all Components.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function show(Request $request)
    {
        return view('dashboard.components', [
            'groups' => ComponentGroup::getAllGroups(),
        ]);
    }
}
