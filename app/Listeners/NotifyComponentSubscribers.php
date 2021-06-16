<?php

namespace App\Listeners;

use App\Events\Components\ComponentUpdated;
use App\Mail\Subscribers\ComponentStatusUpdated;
use Illuminate\Support\Facades\Mail;

class NotifyComponentSubscribers
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
     * @param  ComponentUpdated  $event
     * @return void
     */
    public function handle(ComponentUpdated $event)
    {
        $component = $event->component;
        $original = $component->getOriginal();
        $changes = $component->getChanges();

        $oldStatus = $original['status_id'];
        $newStatus = $changes['status_id'];

        if(array_key_exists('status_id', $changes)){
            foreach ($component->subscribers()->get() as $subscriber){
                Mail::to($subscriber->email)->send(new ComponentStatusUpdated($subscriber, $component, $oldStatus, $newStatus));
            }
        }
    }
}
