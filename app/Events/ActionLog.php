<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Events;

use App\Models\Action;
use App\Models\Setting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Action $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action)
    {
        $disableReadActions = Setting::getBoolean('actionlog_disable_read_actions');

        if($action['type'] === 0 && $disableReadActions)
            return;
        $this->action = new Action();
        $this->action->user = $action['user'];
        $this->action->type = $action['type'];
        $this->action->message = $action['message'];
        $this->action->save();
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
