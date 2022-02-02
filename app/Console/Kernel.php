<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Console;

use App\Statuspage\Version;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:maintenances')->everyMinute()->description('Run Maintenance Checks');
        $schedule->command('check:actionlog')->daily()->description('Run Actionlog Checks');
        $schedule->command('check:metricpoints')->daily()->description('Run Metric Point Checks');
        $schedule->call(function (){
            $fetch = Process::fromShellCommandline('git fetch origin', base_path());
            $fetch->run();
            if (!$fetch->isSuccessful()) {
                throw new ProcessFailedException($fetch);
            }
        })->everyFifteenMinutes()->description('Checks for a newer version.');
        $schedule->call(function (){
            Version::fetchLatestVersion();
        })->everyFiveMinutes()->description('Fetches newest Version from GitHub.');
        $schedule->command('status:fetchuptimerobot')->everyMinute()->description('Import Data from UR');
        $schedule->command('status:fetchexternalstatus')->everyMinute()->description('Import Date from external Status Pages');
        $schedule->command('status:checksubscribers')->everyFiveMinutes()->description('Checks if there are any expired Subscribers and deletes them');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
