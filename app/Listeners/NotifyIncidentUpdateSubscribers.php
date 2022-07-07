<?php

namespace App\Listeners;

use App\Events\Incidents\IncidentUpdateCreated;
use App\Mail\Subscribers\IncidentUpdated;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NotifyIncidentUpdateSubscribers
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
     * @param  IncidentUpdateCreated  $event
     * @return void
     */
    public function handle(IncidentUpdateCreated $event)
    {
        $update = $event->incidentUpdate;
        $incident = $update->incident();

        foreach (Subscriber::all() as $subscriber){
            if ($subscriber->email_verified && $subscriber->incident_updates){
                Mail::to($subscriber->email)->send(new IncidentUpdated($subscriber, $incident, $update));
            }
        }
    }
}
