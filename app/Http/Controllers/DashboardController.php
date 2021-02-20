<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Dashboard.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function show(Request $request)
    {
        // $request->session()->flash('flash.bannerStyle', 'danger');
        // $request->session()->flash('flash.banner', 'Yay it workssss!');

        return view('dashboard', [
            'incidents' => Incident::getIncidents(),
            'maintenances' => Incident::getMaintenances(),
            'upcoming_maintenances' => Incident::getUpcomingMaintenances(),
        ]);
    }
}
