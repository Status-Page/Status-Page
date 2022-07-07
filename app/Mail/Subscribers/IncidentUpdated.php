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

class IncidentUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;
    private Incident $incident;
    private IncidentUpdate $incidentUpdate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Incident $incident, IncidentUpdate $incidentUpdate)
    {
        $this->subscriber = $subscriber;
        $this->incident = $incident;
        $this->incidentUpdate = $incidentUpdate;

        $this->subject = 'Incident Updated: '.$incident->title;
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
                'There is an update for the Incident "'.$this->incident->title.'" ('.$this->incident->id.').',
                'Posted by: '.$this->incidentUpdate->getReporter()->name,
                'Impact: '.$this->incident->getImpactText(),
            ],
            'incidentUpdates' => $this->incident->incidentUpdates()->get(),
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
