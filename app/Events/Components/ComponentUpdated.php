<?php

namespace App\Events\Components;

use App\Models\Component;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComponentUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Component $component;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Component $component)
    {
        $this->component = $component;
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
