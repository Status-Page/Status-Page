<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Console;

use App\Models\Metric;
use App\Models\Setting;
use Cache;
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
            if(Setting::getBoolean('metrics_cache')){
                $metrics = Metric::all();
                foreach ($metrics as $metric){
                    Cache::put('metric_'.$metric->id.'_24_60', $metric->getIntervalPointsLastHours(24));
                    Cache::put('metric_'.$metric->id.'_24_30', $metric->getIntervalPointsLastHours(24, 30));
                    Cache::put('metric_'.$metric->id.'_24_15', $metric->getIntervalPointsLastHours(24, 15));
                    Cache::put('metric_'.$metric->id.'_24_5', $metric->getIntervalPointsLastHours(24, 5));

                    Cache::put('metric_'.$metric->id.'_48_60', $metric->getIntervalPointsLastHours(48));
                    Cache::put('metric_'.$metric->id.'_48_30', $metric->getIntervalPointsLastHours(48, 30));
                    Cache::put('metric_'.$metric->id.'_48_15', $metric->getIntervalPointsLastHours(48, 15));
                    Cache::put('metric_'.$metric->id.'_48_5', $metric->getIntervalPointsLastHours(48, 5));

                    Cache::put('metric_'.$metric->id.'_72_60', $metric->getIntervalPointsLastHours(72));
                    Cache::put('metric_'.$metric->id.'_72_30', $metric->getIntervalPointsLastHours(72, 30));
                    Cache::put('metric_'.$metric->id.'_72_15', $metric->getIntervalPointsLastHours(72, 15));
                    Cache::put('metric_'.$metric->id.'_72_5', $metric->getIntervalPointsLastHours(72, 5));

                    Cache::put('metric_'.$metric->id.'_168_60', $metric->getIntervalPointsLastHours(168));
                    Cache::put('metric_'.$metric->id.'_168_30', $metric->getIntervalPointsLastHours(168, 30));
                    Cache::put('metric_'.$metric->id.'_168_15', $metric->getIntervalPointsLastHours(168, 15));
                    Cache::put('metric_'.$metric->id.'_168_5', $metric->getIntervalPointsLastHours(168, 5));
                }
            }
        })->everyFiveMinutes()->description('Caches Metric Data');
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
