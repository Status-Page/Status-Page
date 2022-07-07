<?php

namespace App\Mail\Subscribers;

use App\Models\Component;
use App\Models\Status;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComponentStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;
    private Component $component;
    private string $oldStatus;
    private string $newStatus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Component $component, string $oldStatus, string $newStatus)
    {
        $this->subscriber = $subscriber;
        $this->component = $component;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;

        $this->subject = 'Component Status Updated: '.$component->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $unsubscribeKey = $this->subscriber->getUnsubscribeKey() ?: $this->subscriber->generateUnsubscribeKey();
        $manageKey = $this->subscriber->getManageKey() ?: $this->subscriber->generateManageKey();

        return $this->markdown('vendor.notifications.email', [
            'greeting' => 'Hello!',
            'introLines' => [
                'The Status of the Component '.$this->component->name.' was updated:',
                'from "'.Status::query()->where('id', '=', $this->oldStatus)->first()->name.'" to "'.Status::query()->where('id', '=', $this->newStatus)->first()->name.'".',
            ],
            'actionText' => 'View Status Page',
            'actionUrl' => route('home'),
            'displayableActionUrl' => route('home'),
            'outroLines' => [
                'You can always unsubscribe from this Notifications, by clicking the Link below.'
            ],
            'unsubscribe_id' => $this->subscriber->id,
            'unsubscribe_key' => $unsubscribeKey,
            'manage_key' => $manageKey,
        ]);
    }
}
