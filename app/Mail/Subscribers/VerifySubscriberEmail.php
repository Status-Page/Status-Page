<?php

namespace App\Mail\Subscribers;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySubscriberEmail extends Mailable implements ShouldQueue
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

        $this->subject = 'Verify your E-Mail at '.config('app.name');
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
                'Please verify your e-mail below to receive Notifications about Components and Incidents!',
                'Be aware, that this Link will expire after 24 hours.',
            ],
            'actionText' => 'Verify Email',
            'actionUrl' => route('subscribers.verify', ['subscriber' => $this->subscriber->id, 'key' => $this->key]),
            'displayableActionUrl' => route('subscribers.verify', ['subscriber' => $this->subscriber->id, 'key' => $this->key]),
            'outroLines' => [
                'You can always unsubscribe from this Notifications, by clicking the Link in the latest Notification.'
            ],
        ]);
    }
}
