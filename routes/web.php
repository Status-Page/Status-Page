<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardComponentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardIncidentController;
use App\Http\Controllers\RefreshController;
use App\Http\Livewire\Dashboard\Administration\Users;
use App\Http\Livewire\Dashboard\Metrics\Metrics;
use App\Mail\Incidents\Scheduled\ScheduledIncidentStarted;
use App\Models\Incident;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::get('/dashboard/incidents', [DashboardIncidentController::class, 'showIncidents'])->middleware(['can:read_incidents'])->name('dashboard.incidents');
    Route::get('/dashboard/incidents/maintenances', [DashboardIncidentController::class, 'showMaintenances'])->middleware(['can:read_incidents'])->name('dashboard.incidents.maintenances');
    Route::get('/dashboard/incidents/past', [DashboardIncidentController::class, 'showPastIncidents'])->middleware(['can:read_incidents'])->name('dashboard.incidents.past');
    Route::get('/dashboard/incidents/{id}', [DashboardIncidentController::class, 'showIncident'])->middleware(['can:edit_incidents'])->name('dashboard.incidents.show');

    Route::get('/dashboard/components', [DashboardComponentController::class, 'show'])->middleware(['can:read_components'])->name('dashboard.components');
    Route::get('/dashboard/metrics', Metrics::class)->middleware(['can:read_metrics'])->name('dashboard.metrics');

    Route::get('/dashboard/admin/users', Users::class)->middleware(['can:read_users'])->name('dashboard.admin.users');
    Route::get('/dashboard/admin/actionlog', [AdminController::class, 'actionLog'])->middleware(['can:read_actionlog'])->name('dashboard.admin.actionlog');
});

/* Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/

/* Route::get('/mailtest', function (){
    $incident = Incident::query()->where('id', '=', 19)->first();
    $updates = $incident->incidentUpdates()->get();

    return new ScheduledIncidentStarted($incident, $updates);
}); */
