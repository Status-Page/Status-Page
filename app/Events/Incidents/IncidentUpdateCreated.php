<?php

namespace App\Events\Incidents;

use App\Models\IncidentUpdate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncidentUpdateCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public IncidentUpdate $incidentUpdate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(IncidentUpdate $incidentUpdate)
    {
        $this->incidentUpdate = $incidentUpdate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
