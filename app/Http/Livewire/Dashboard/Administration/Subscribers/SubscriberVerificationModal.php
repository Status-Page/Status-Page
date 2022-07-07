<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Administration\Subscribers;

use App\Events\ActionLog;
use App\Mail\Subscribers\ManageSubscriptionMail;
use App\Models\Incident;
use App\Models\Subscriber;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SubscriberVerificationModal extends Component
{
    public Subscriber $subscriber;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.administration.subscribers.subscriber-verification-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Subscriber '.$this->subscriber->email.' (ID: '.$this->subscriber->id.')',
        ));

        $key = $this->subscriber->generateVerificationKey();
        Mail::to($this->subscriber->email)->send(new ManageSubscriptionMail($this->subscriber, $key));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
