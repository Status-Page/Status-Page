<?php

namespace App\Listeners;

use App\Events\ActionLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddActionLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionLog  $event
     * @return void
     */
    public function handle(ActionLog $event)
    {
        //
    }
}
