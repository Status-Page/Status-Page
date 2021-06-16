<?php

namespace App\Listeners\Subscribers;

use App\Events\Subscribers\SubscriberAdded;
use App\Mail\Subscribers\VerifySubscriberEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
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
        $key = $subscriber->generateVerificationKey();
        Mail::to($subscriber->email)->send(new VerifySubscriberEmail($subscriber, $key));
    }
}
