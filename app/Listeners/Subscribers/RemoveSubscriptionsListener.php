<?php

namespace App\Listeners\Subscribers;

use App\Events\Subscribers\SubscriberDeletingEvent;

class RemoveSubscriptionsListener
{
    public function __construct()
    {
    }

    public function handle(SubscriberDeletingEvent $event)
    {
        $event->subscriber->components()->detach();
    }
}
