<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage\Helper;


use App\Models\Component;
use App\Models\Setting;
use App\Models\UptimeRobotMonitor;

class SPHelper
{
    public static function isManagedComponent(int $component_id): bool
    {
        $managed = false;
        if(Setting::getString('uptimerobot_key') != ''){
            if(UptimeRobotMonitor::query()->where('component_id', $component_id)->where('paused', false)->count() > 0)
                $managed = true;
        }
        $component = Component::query()->where('id', $component_id)->first();
        if ($component->linked_status_provider_id != null)
            $managed = true;

        return $managed;
    }

    public static function isManagedMetric(int $metric_id): bool
    {
        if(Setting::getString('uptimerobot_key') == '') return false;
        return UptimeRobotMonitor::query()->where('metric_id', $metric_id)->where('paused', false)->count() > 0;
    }
}
