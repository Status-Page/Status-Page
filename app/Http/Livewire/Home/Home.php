<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use \App\Models\Metric;
use Session;

class Home extends Component
{
    public $interval = 60;
    public $lastHours = 24;

    public function render()
    {
        return view('livewire.home.home', [
            'metrics' => Metric::query()->where('visibility', true)->orderBy('order')->get()
        ])->layout('layouts.guest');
    }

    public function mount(){
        $this->interval = Session::get('interval', $this->interval);
        $this->lastHours = Session::get('lastHours', $this->lastHours);
    }

    public function updatedInterval(){
        Session::put('interval', $this->interval);
    }

    public function updatedLastHours(){
        Session::put('lastHours', $this->lastHours);
    }

    public function changeDarkmode(){
        session()->put('darkmode', !session()->get('darkmode', config('statuspage.darkmode')));
        $this->redirectRoute('home');
    }
}
