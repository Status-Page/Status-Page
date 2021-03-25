<?php

namespace App\Http\Livewire\Dashboard\Administration;

use Livewire\Component;

class AppSettings extends Component
{

    protected $listeners = ['refreshData'];

    public function render()
    {
        return view('livewire.dashboard.administration.app-settings', []);
    }

    public function refreshData(){
        // Placeholder
    }
}
