<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    /*
     * |---------------------------------------------
     * |    General
     * |---------------------------------------------
     */
    require 'api/general.php';

    Route::middleware('auth:sanctum')->group(function (){
        /*
         * |---------------------------------------------
         * |    ConfigCat
         * |---------------------------------------------
         */
        require 'api/configcat.php';

        /*
         * |---------------------------------------------
         * |    User
         * |---------------------------------------------
         */
        require 'api/user.php';

        /*
         * |---------------------------------------------
         * |    Components
         * |---------------------------------------------
         */
        require 'api/components.php';

        /*
         * |---------------------------------------------
         * |    Component Groups
         * |---------------------------------------------
         */
        require 'api/component_groups.php';

        /*
         * |---------------------------------------------
         * |    Incidents
         * |---------------------------------------------
         */
        require 'api/incidents/incidents.php';

        /*
         * |---------------------------------------------
         * |    Incident Updates
         * |---------------------------------------------
         */
        require 'api/incidents/updates.php';

        /*
         * |---------------------------------------------
         * |    Maintenances
         * |---------------------------------------------
         */
        require 'api/maintenances/maintenances.php';

        /*
         * |---------------------------------------------
         * |    Maintenance Updates
         * |---------------------------------------------
         */
        require 'api/maintenances/updates.php';

        /*
         * |---------------------------------------------
         * |    Metrics
         * |---------------------------------------------
         */
        require 'api/metrics/metrics.php';

        /*
         * |---------------------------------------------
         * |    Metric Points
         * |---------------------------------------------
         */
        require 'api/metrics/points.php';

        /*
         * |---------------------------------------------
         * |    Statuses
         * |---------------------------------------------
         */
        require 'api/statuses.php';
    });
});
