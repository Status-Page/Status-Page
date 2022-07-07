<?php

namespace App\Http\Livewire\Home\Subscribers;

use App\Mail\Subscribers\ManageSubscriptionMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UnsubscribeSubscriber extends Component
{
    public Subscriber $subscriber;
    public string $key;

    public function mount(Subscriber $subscriber, string $key){
        $this->subscriber = $subscriber;
        $this->key = $key;
    }

    public function render()
    {
        $error = true;
        if($this->subscriber->unsubscribe_key != null && $this->key === $this->subscriber->unsubscribe_key){
            $this->subscriber->delete();
            $error = false;
        }

        return view('livewire.home.subscribers.unsubscribe-subscriber', [
            'error' => $error,
        ])->layout('layouts.guest');
    }
}
