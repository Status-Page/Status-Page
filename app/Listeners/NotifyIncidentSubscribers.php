<?php

namespace App\Listeners;

use App\Events\Incidents\IncidentUpdated;
use App\Mail\Subscribers\IncidentCreated;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NotifyIncidentSubscribers
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
     * @param  IncidentUpdated  $event
     * @return void
     */
    public function handle(IncidentUpdated $event)
    {
        $incident = $event->incident;

        if($incident->visibility){
            foreach (Subscriber::all() as $subscriber){
                if ($subscriber->email_verified && $subscriber->incident_updates){
                    Mail::to($subscriber->email)->send(new IncidentCreated($subscriber, $incident));
                }
            }
        }
    }
}
