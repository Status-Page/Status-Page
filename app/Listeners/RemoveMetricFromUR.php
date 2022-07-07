<?php

namespace App\Listeners;

use App\Events\MetricDeleting;
use App\Models\UptimeRobotMonitor;
use App\Statuspage\Helper\SPHelper;

class RemoveMetricFromUR
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MetricDeleting  $event
     * @return void
     */
    public function handle(MetricDeleting $event)
    {
        $metric = $event->metric;
        if(SPHelper::isManagedMetric($metric->id)){
            UptimeRobotMonitor::query()->where('metric_id', $metric->id)->update([
                'metric_id' => null,
            ]);
        }
    }
}
