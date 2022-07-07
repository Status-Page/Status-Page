<?php

namespace App\Http\Livewire\Dashboard\Administration\Subscribers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\Subscriber;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubscriberAddModal extends Component
{
    use PasswordValidationRules;

    public bool $modal = false;
    public Subscriber $subscriber;
    protected array $rules;

    public function __construct($id = null)
    {
        $this->rules = [
            'subscriber.email' => ['required', 'email', 'min:0', 'max:255', Rule::unique('subscribers', 'email')],
        ];

        parent::__construct($id);
    }

    public function render()
    {
        return view('livewire.dashboard.administration.subscribers.subscriber-add-modal');
    }

    public function start(){
        $this->subscriber = new Subscriber();

        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->subscriber->save();
        $this->subscriber->generateManageKey();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Subscriber '.$this->subscriber->email.' (ID: '.$this->subscriber->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
