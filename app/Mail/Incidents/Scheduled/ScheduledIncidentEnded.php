<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Mail\Incidents\Scheduled;

use App\Models\Incident;
use App\Models\IncidentUpdate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledIncidentEnded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Incident $incident;

    /**
     * @var $updates IncidentUpdate[]
     */
    public $updates;

    /**
     * Create a new message instance.
     *
     * @param Incident $incident
     * @param IncidentUpdate[] $updates
     */
    public function __construct($incident, $updates)
    {
        $this->incident = $incident;
        $this->updates = $updates;

        $this->subject = 'Scheduled Maintenance End: '.$incident->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('mail.incident-detail');
        return $this->markdown('vendor.notifications.email', [
            'greeting' => 'Hello '.$this->to[0]['name'].',',
            'introLines' => [
                'just as a friendly reminder:',
                'Your scheduled Maintenance '.$this->incident->title.' has ended now.',
            ],
            'actionText' => 'Open Dashboard',
            'actionUrl' => route('dashboard.incidents.past'),
            'displayableActionUrl' => route('dashboard.incidents.past'),
            'outroLines' => [
                ''
            ],
        ]);
    }
}
