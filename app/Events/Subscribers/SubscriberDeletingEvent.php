<?php

namespace App\Events\Subscribers;

use App\Models\Subscriber;
use Illuminate\Foundation\Events\Dispatchable;

class SubscriberDeletingEvent
{
    use Dispatchable;

    public Subscriber $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
