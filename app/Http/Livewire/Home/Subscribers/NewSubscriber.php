<?php

namespace App\Http\Livewire\Home\Subscribers;

use App\Mail\Subscribers\ManageSubscriptionMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class NewSubscriber extends Component
{
    public string $email = '';
    public bool $submitted = false;
    public bool $success = false;
    public bool $managing = false;
    public bool $error = false;
    public $errors = null;

    public function render()
    {
        return view('livewire.home.subscribers.new-subscriber')->layout('layouts.guest');
    }

    public function signUp(){
        $this->submitted = true;
        $val = Validator::make(['email' => $this->email], ['email' => 'email|required']);
        $val->validate();
        if(!$val->failed()){
            $subQuery = Subscriber::query()->where('email', '=', $this->email);

            $alreadyAvailable = $subQuery->count() > 0;
            if(!$alreadyAvailable){
                $sub = new Subscriber();
                $sub->email = $this->email;
                $sub->save();
                $sub->generateManageKey();
            }else{
                $sub = $subQuery->first();
                if(!$sub->email_verified){
                    $key = $sub->generateVerificationKey();
                    Mail::to($sub->email)->send(new ManageSubscriptionMail($sub, $key));
                }else{
                    $manageKey = $sub->getManageKey();
                    Mail::to($sub->email)->send(new ManageSubscriptionMail($sub, $manageKey));
                }
            }
            $this->success = true;
        }else{
            $this->error = true;
            $this->errors = $val->errors();
        }
        $this->emit('refreshComponent');
    }

    public function manage(){
        $this->submitted = true;
        $this->managing = true;
        $val = Validator::make(['email' => $this->email], ['email' => 'email|required']);
        $val->validate();
        if(!$val->failed()){
            /**
             * @var Subscriber $subscriber
             */
            $subscriber = Subscriber::query()->where('email', '=', $this->email)->first();
            if($subscriber){
                if($subscriber->email_verified){
                    $manageKey = $subscriber->getManageKey();
                    Mail::to($subscriber->email)->send(new ManageSubscriptionMail($subscriber, $manageKey));
                }
            }
            $this->success = true;
        }else{
            $this->error = true;
            $this->errors = $val->errors();
        }
        $this->emit('refreshComponent');
    }
}
