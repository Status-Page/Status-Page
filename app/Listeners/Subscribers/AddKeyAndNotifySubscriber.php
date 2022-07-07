<?php

namespace App\Listeners\Subscribers;

use App\Events\Subscribers\SubscriberAdded;
use App\Mail\Subscribers\ManageSubscriptionMail;
use Illuminate\Support\Facades\Mail;

class AddKeyAndNotifySubscriber
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
     * @param  SubscriberAdded  $event
     * @return void
     */
    public function handle(SubscriberAdded $event)
    {
        $subscriber = $event->subscriber;
        if(!$subscriber->verified_email){
            $key = $subscriber->generateVerificationKey();
            Mail::to($subscriber->email)->send(new ManageSubscriptionMail($subscriber, $key));
        }
    }
}
