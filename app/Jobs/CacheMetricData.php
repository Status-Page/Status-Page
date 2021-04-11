<?php

namespace App\Jobs;

use App\Models\Metric;
use App\Models\Setting;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CacheMetricData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $lastHours;

    /**
     * Create a new job instance.
     *
     * @param int $lastHours
     */
    public function __construct(int $lastHours)
    {
        $this->lastHours = $lastHours;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(Setting::getBoolean('metrics_cache')){
            $metrics = Metric::query()->where('visibility', true)->get();
            foreach ($metrics as $metric){
                Log::info('[CACHE] Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 60');
                Cache::put('metric_'.$metric->id.'_'.$this->lastHours.'_60', $metric->getIntervalPointsLastHours($this->lastHours));
                Log::info('[CACHE] SUCCESS! Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 60');

                Log::info('[CACHE] Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 30');
                Cache::put('metric_'.$metric->id.'_'.$this->lastHours.'_30', $metric->getIntervalPointsLastHours($this->lastHours, 30));
                Log::info('[CACHE] SUCCESS! Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 30');

                Log::info('[CACHE] Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 15');
                Cache::put('metric_'.$metric->id.'_'.$this->lastHours.'_15', $metric->getIntervalPointsLastHours($this->lastHours, 15));
                Log::info('[CACHE] SUCCESS! Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 15');

                // Log::info('[CACHE] Metric '.$metric->title.' for LH: '.$this->lastHours.' and M: 5');
                // Cache::put('metric_'.$metric->id.'_'.$this->lastHours.'_5', $metric->getIntervalPointsLastHours($this->lastHours, 5));
            }
        }
    }
}
