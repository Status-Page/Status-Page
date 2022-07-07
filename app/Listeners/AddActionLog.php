<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Listeners;

use App\Events\ActionLog;

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
