<?php

namespace App\Mail\Subscribers;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManageSubscriptionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;
    private string $key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, string $key)
    {
        $this->subscriber = $subscriber;
        $this->key = $key;

        $this->subject = 'Manage your Subscription at '.config('app.name');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.email', [
            'greeting' => 'Hello!',
            'introLines' => [
                'Click the Button below to Manage your Subscription!',
            ],
            'actionText' => 'Manage Subscription',
            'actionUrl' => route('subscribers.manage', ['subscriber' => $this->subscriber->id, 'key' => $this->key]),
            'displayableActionUrl' => route('subscribers.manage', ['subscriber' => $this->subscriber->id, 'key' => $this->key]),
            'outroLines' => [
                'You can always unsubscribe from this Notifications, by clicking the Link in the latest Notification.'
            ],
        ]);
    }
}
