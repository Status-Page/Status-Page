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

class ScheduledIncidentStarted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Incident $incident;

    /**
     * Create a new message instance.
     *
     * @param Incident $incident
     */
    public function __construct(Incident $incident)
    {
        $this->incident = $incident;

        $this->subject = 'Scheduled Maintenance Started: '.$incident->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.email', [
            'greeting' => 'Hello '.($this->to ? $this->to[0]['name'] : 'None').',',
            'introLines' => [
                'just as a friendly reminder:',
                'Your scheduled Maintenance '.$this->incident->title.' has started now.',
                'If set, your Maintenance will end at: '.$this->incident->end_at ?: 'No set',
            ],
            'actionText' => 'Open Dashboard',
            'actionUrl' => route('dashboard.maintenances'),
            'displayableActionUrl' => route('dashboard.maintenances'),
            'outroLines' => [
                ''
            ],
        ]);
    }
}
