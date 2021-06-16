<?php

namespace App\Http\Livewire\Home\Subscribers;

use App\Mail\Subscribers\VerifySubscriberEmail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class NewSubscriber extends Component
{
    public function render()
    {
        $success = false;
        $submitted = false;
        $errors = null;

        if($_POST != [] && $_POST['email'] != null){
            $email = $_POST['email'];
            $submitted = true;
            $val = Validator::make(['email' => $email], ['email' => 'email|required']);
            $val->validate();
            if(!$val->failed()){
                $subQuery = Subscriber::query()->where('email', '=', $email);

                $alreadyAvailable = $subQuery->count() > 0;
                if(!$alreadyAvailable){
                    $sub = new Subscriber();
                    $sub->email = $email;
                    $sub->save();
                    $sub->generateManageKey();
                }else{
                    $sub = $subQuery->first();
                    if(!$sub->email_verified){
                        $key = $sub->generateVerificationKey();
                        Mail::to($sub->email)->send(new VerifySubscriberEmail($sub, $key));
                    }
                }
                $success = true;
            }else{
                $errors = $val->errors();
            }
        }

        return view('livewire.home.subscribers.new-subscriber', [
            'submitted' => $submitted,
            'success' => $success,
            'validation_errors' => $errors,
        ])->layout('layouts.guest');
    }
}
