<?php

namespace App\Http\Livewire\Dashboard\Administration;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        return view('livewire.dashboard.administration.users', [
            'users' => User::all(),
        ]);
    }
}
