<?php

namespace App\Http\Livewire\Home\Subscribers;

use App\Mail\Subscribers\VerifySubscriberEmail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class VerifiedSubscriber extends Component
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
        if($this->subscriber->verification_key != null && Hash::check($this->key, $this->subscriber->verification_key)){
            $this->subscriber->verifyEmail();
            $error = false;
        }

        return view('livewire.home.subscribers.verified-subscriber', [
            'error' => $error,
        ])->layout('layouts.guest');
    }
}
