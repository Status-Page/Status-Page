<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Providers;

use App\Events\Components\ComponentDeleting;
use App\Events\Components\ComponentUpdated;
use App\Events\Incidents\IncidentUpdateCreated;
use App\Events\Incidents\IncidentUpdated;
use App\Events\MetricDeleting;
use App\Events\Subscribers\SubscriberAdded;
use App\Events\Subscribers\SubscriberDeletingEvent;
use App\Listeners\Components\RemoveComponentSubscriptionsListener;
use App\Listeners\NotifyComponentSubscribers;
use App\Listeners\NotifyIncidentSubscribers;
use App\Listeners\NotifyIncidentUpdateSubscribers;
use App\Listeners\RemoveComponentFromUR;
use App\Listeners\RemoveMetricFromUR;
use App\Listeners\Subscribers\AddKeyAndNotifySubscriber;
use App\Listeners\Subscribers\RemoveSubscriptionsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ComponentDeleting::class => [
            RemoveComponentFromUR::class,
            RemoveComponentSubscriptionsListener::class,
        ],
        MetricDeleting::class => [
            RemoveMetricFromUR::class,
        ],
        SubscriberAdded::class => [
            AddKeyAndNotifySubscriber::class,
        ],
        ComponentUpdated::class => [
            NotifyComponentSubscribers::class,
        ],
        IncidentUpdated::class => [
            NotifyIncidentSubscribers::class,
        ],
        IncidentUpdateCreated::class => [
            NotifyIncidentUpdateSubscribers::class,
        ],
        SubscriberDeletingEvent::class => [
            RemoveSubscriptionsListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
