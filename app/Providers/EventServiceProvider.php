<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Providers;

use App\Events\ComponentDeleting;
use App\Events\Components\ComponentUpdated;
use App\Events\Incidents\IncidentUpdateCreated;
use App\Events\Incidents\IncidentUpdated;
use App\Events\MetricDeleting;
use App\Events\Subscribers\SubscriberAdded;
use App\Listeners\NotifyComponentSubscribers;
use App\Listeners\NotifyIncidentSubscribers;
use App\Listeners\NotifyIncidentUpdateSubscribers;
use App\Listeners\RemoveComponentFromUR;
use App\Listeners\RemoveMetricFromUR;
use App\Listeners\Subscribers\AddKeyAndNotifySubscriber;
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
