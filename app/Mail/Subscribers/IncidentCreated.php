<?php

namespace App\Mail\Subscribers;

use App\Models\Component;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Status;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;
    private Incident $incident;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Incident $incident)
    {
        $this->subscriber = $subscriber;
        $this->incident = $incident;

        $this->subject = 'New Incident: '.$incident->title;
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

        return $this->markdown('mail.subscribers.incident-update', [
            'greeting' => 'Hello!',
            'introLines' => [
                'There is a new Incident "'.$this->incident->title.'" ('.$this->incident->id.').',
                'Posted by: '.$this->incident->getReporter()->name,
                'Impact: '.$this->incident->getImpactText(),
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
