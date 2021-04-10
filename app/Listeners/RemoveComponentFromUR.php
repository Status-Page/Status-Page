<?php

namespace App\Listeners;

use App\Events\ComponentDeleting;
use App\Models\UptimeRobotMonitor;
use App\Statuspage\Helper\SPHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  ComponentDeleting  $event
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
