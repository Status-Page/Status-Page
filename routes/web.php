<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Dashboard\Administration\Users;
use App\Http\Livewire\Dashboard\Administration\ViewActionLog;
use App\Http\Livewire\Dashboard\Components\Components;
use App\Http\Livewire\Dashboard\Incidents\Incidents;
use App\Http\Livewire\Dashboard\Incidents\PastIncidents;
use App\Http\Livewire\Dashboard\Maintenances\Maintenances;
use App\Http\Livewire\Dashboard\Maintenances\PastMaintenances;
use App\Http\Livewire\Dashboard\Metrics\Metrics;
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
})->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::get('/dashboard/incidents', Incidents::class)->middleware(['can:read_incidents'])->name('dashboard.incidents');
    Route::get('/dashboard/incidents/past', PastIncidents::class)->middleware(['can:read_incidents'])->name('dashboard.incidents.past');
    Route::get('/dashboard/maintenances', Maintenances::class)->middleware(['can:read_incidents'])->name('dashboard.maintenances');
    Route::get('/dashboard/maintenances/past', PastMaintenances::class)->middleware(['can:read_incidents'])->name('dashboard.maintenances.past');

    Route::get('/dashboard/components', Components::class)->middleware(['can:read_components'])->name('dashboard.components');
    Route::get('/dashboard/metrics', Metrics::class)->middleware(['can:read_metrics'])->name('dashboard.metrics');

    Route::get('/dashboard/admin/users', Users::class)->middleware(['can:read_users'])->name('dashboard.admin.users');
    Route::get('/dashboard/admin/actionlog', ViewActionLog::class)->middleware(['can:read_actionlog'])->name('dashboard.admin.actionlog');
});
