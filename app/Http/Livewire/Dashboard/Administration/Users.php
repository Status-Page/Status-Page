<?php

namespace App\Http\Livewire\Dashboard\Administration;

use App\Events\ActionLog;
use App\Models\User;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Users',
        ));

        return view('livewire.dashboard.administration.users', [
            'users' => User::query()->search('name', $this->search)->paginate(),
        ]);
    }

    public function refreshData(){
        // Placeholder
    }
}
