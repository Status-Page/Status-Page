<?php

namespace App\Listeners;

use App\Events\Components\ComponentDeleting;
use App\Models\UptimeRobotMonitor;
use App\Statuspage\Helper\SPHelper;

class RemoveComponentFromUR
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
     * @param  \App\Events\Components\ComponentDeleting  $event
     * @return void
     */
    public function handle(ComponentDeleting $event)
    {
        $component = $event->component;
        if(SPHelper::isManagedComponent($component->id)){
            UptimeRobotMonitor::query()->where('component_id', $component->id)->update([
                'component_id' => null,
            ]);
        }
    }
}
