<?php

namespace App\Http\Livewire\Dashboard\Administration;

use App\Events\ActionLog;
use App\Models\User;
use Auth;
use Livewire\Component;

class Users extends Component
{
    protected $listeners = ['refreshData'];

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Users',
        ));

        return view('livewire.dashboard.administration.users', [
            'users' => User::all(),
        ]);
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.admin.users');
    }
}
