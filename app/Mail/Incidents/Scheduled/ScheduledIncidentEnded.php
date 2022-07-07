<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Mail\Incidents\Scheduled;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledIncidentEnded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Incident $incident;

    /**
     * Create a new message instance.
     *
     * @param Incident $incident
     */
    public function __construct($incident)
    {
        $this->incident = $incident;

        $this->subject = 'Scheduled Maintenance Ended: '.$incident->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.email', [
            'greeting' => 'Hello '.$this->to[0]['name'].',',
            'introLines' => [
                'just as a friendly reminder:',
                'Your scheduled Maintenance '.$this->incident->title.' has ended now.',
            ],
            'actionText' => 'Open Dashboard',
            'actionUrl' => route('dashboard.maintenances.past'),
            'displayableActionUrl' => route('dashboard.maintenances.past'),
            'outroLines' => [
                ''
            ],
        ]);
    }
}
