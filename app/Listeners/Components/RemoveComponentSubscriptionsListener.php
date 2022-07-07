<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentDeleting;

class RemoveComponentSubscriptionsListener
{
    public function __construct()
    {
    }

    public function handle(ComponentDeleting $event)
    {
        $event->component->subscribers()->delete();
    }
}
