<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Administration\Subscribers;

use App\Events\ActionLog;
use App\Models\Subscriber;
use Auth;
use Livewire\Component;

class SubscriberDeleteModal extends Component
{
    public Subscriber $subscriber;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.administration.subscribers.subscriber-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Subscriber '.$this->subscriber->email.' (ID: '.$this->subscriber->id.')',
        ));

        $this->subscriber->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
