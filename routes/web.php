<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Dashboard\Administration\AppSettings;
use App\Http\Livewire\Dashboard\Administration\Plugins\LinkedStatus\ExternalPages;
use App\Http\Livewire\Dashboard\Administration\Plugins\UptimeRobot\Monitors;
use App\Http\Livewire\Dashboard\Administration\Subscribers\Subscribers;
use App\Http\Livewire\Dashboard\Administration\Users;
use App\Http\Livewire\Dashboard\Administration\ViewActionLog;
use App\Http\Livewire\Dashboard\Components\Components;
use App\Http\Livewire\Dashboard\Incidents\Incidents;
use App\Http\Livewire\Dashboard\Incidents\IncidentUpdates;
use App\Http\Livewire\Dashboard\Incidents\PastIncidents;
use App\Http\Livewire\Dashboard\Maintenances\Maintenances;
use App\Http\Livewire\Dashboard\Maintenances\MaintenanceUpdates;
use App\Http\Livewire\Dashboard\Maintenances\PastMaintenances;
use App\Http\Livewire\Dashboard\Metrics\Metrics;
use App\Http\Livewire\Home\Home;
use App\Http\Livewire\Home\Subscribers\NewSubscriber;
use App\Http\Livewire\Home\Subscribers\UnsubscribeSubscriber;
use App\Http\Livewire\Home\Subscribers\VerifiedSubscriber;
use App\Mail\Incidents\Scheduled\ScheduledIncidentStarted;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

Route::get('/', Home::class)->name('home');

Route::get('/subscribe', NewSubscriber::class)->name('subscribers.new');
Route::post('/subscribe', NewSubscriber::class);
Route::get('/subscribers/{subscriber}/verify/{key}', VerifiedSubscriber::class)->name('subscribers.verify');
Route::get('/subscribers/{subscriber}/unsubscribe/{key}', UnsubscribeSubscriber::class)->name('subscribers.unsubscribe');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::get('/dashboard/incidents', Incidents::class)->middleware(['can:read_incidents'])->name('dashboard.incidents');
    Route::get('/dashboard/incidents/{id}/updates', IncidentUpdates::class)->middleware(['can:read_incidents'])->name('dashboard.incidents.updates');
    Route::get('/dashboard/incidents/past', PastIncidents::class)->middleware(['can:read_incidents'])->name('dashboard.incidents.past');

    Route::get('/dashboard/maintenances', Maintenances::class)->middleware(['can:read_incidents'])->name('dashboard.maintenances');
    Route::get('/dashboard/maintenances/{id}/updates', MaintenanceUpdates::class)->middleware(['can:read_incidents'])->name('dashboard.maintenances.updates');
    Route::get('/dashboard/maintenances/past', PastMaintenances::class)->middleware(['can:read_incidents'])->name('dashboard.maintenances.past');

    Route::get('/dashboard/components', Components::class)->middleware(['can:read_components'])->name('dashboard.components');

    Route::get('/dashboard/metrics', Metrics::class)->middleware(['can:read_metrics'])->name('dashboard.metrics');

    Route::get('/dashboard/admin/settings', AppSettings::class)->middleware(['can:read_settings'])->name('dashboard.admin.settings');
    Route::get('/dashboard/admin/users', Users::class)->middleware(['can:read_users'])->name('dashboard.admin.users');
    Route::get('/dashboard/admin/subscribers', Subscribers::class)->middleware(['can:read_subscribers'])->name('dashboard.admin.subscribers');
    Route::get('/dashboard/admin/actionlog', ViewActionLog::class)->middleware(['can:read_actionlog'])->name('dashboard.admin.actionlog');
    Route::get('/dashboard/admin/plugins/uptimerobot', Monitors::class)->middleware(['can:read_settings'])->name('dashboard.admin.plugins.uptimerobot');
    Route::get('/dashboard/admin/plugins/linked_status', ExternalPages::class)->middleware(['can:read_settings'])->name('dashboard.admin.plugins.linked_status');
});
