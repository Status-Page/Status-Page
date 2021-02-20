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

class DashboardIncidentController extends Controller
{
    /**
     * Displays current Incidents.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showIncidents(Request $request)
    {
        return view('dashboard.incidents', [
            'incidents' => Incident::getIncidents(),
            'old_incidents' => Incident::getPastIncidents(),
            'maintenances' => Incident::getMaintenances(),
            'upcoming_maintenances' => Incident::getUpcomingMaintenances(),
        ]);
    }

    /**
     * Display incidents in the Past.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showPastIncidents(Request $request)
    {
        return view('dashboard.incidents.past', [
            'incidents' => Incident::getIncidents(),
            'old_incidents' => Incident::getPastIncidents(),
            'old_maintenances' => Incident::getPastMaintenances(),
            'maintenances' => Incident::getMaintenances(),
            'upcoming_maintenances' => Incident::getUpcomingMaintenances(),
        ]);
    }

    /**
     * Display incidents in the Past.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showMaintenances(Request $request)
    {
        return view('dashboard.incidents.maintenances', [
            'incidents' => Incident::getIncidents(),
            'old_incidents' => Incident::getPastIncidents(),
            'old_maintenances' => Incident::getPastMaintenances(),
            'maintenances' => Incident::getMaintenances(),
            'upcoming_maintenances' => Incident::getUpcomingMaintenances(),
        ]);
    }
}
