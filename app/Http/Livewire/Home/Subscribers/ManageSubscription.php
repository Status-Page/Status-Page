<?php

namespace App\Http\Livewire\Home\Subscribers;

use App\Mail\Subscribers\ManageSubscriptionMail;
use App\Models\Component as StatusComponent;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ManageSubscription extends Component
{
    protected $listeners = ['refreshData'];

    public Subscriber $subscriber;
    public string $key;

    public function mount(Subscriber $subscriber, string $key){
        $this->subscriber = $subscriber;
        $this->key = $key;

        if($this->subscriber->manage_key !== $this->key)
            return $this->redirectRoute('home');
    }

    public function render()
    {
        return view('livewire.home.subscribers.manage-subscription', [
            'components' => StatusComponent::query()->get()->filter(function ($item) {
                return !in_array($item->id, array_column($this->subscriber->components()->get()->toArray(), 'id'));
            }),
        ])->layout('layouts.guest');
    }

    public function toggleReceiveIncidentUpdates(){
        $this->subscriber->incident_updates = !$this->subscriber->incident_updates;
        $this->subscriber->save();
        $this->emit('refreshComponent');
    }

    public function addSubscription(StatusComponent $component) {
        $this->subscriber->components()->attach($component);
        $this->emit('refreshComponent');
    }

    public function removeSubscription(StatusComponent $component) {
        $this->subscriber->components()->detach($component);
        $this->emit('refreshComponent');
    }

    public function refreshData(){
        // Placeholder
    }
}
