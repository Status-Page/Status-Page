<?php

namespace App\Http\Livewire\Dashboard\Administration;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\User;
use Auth;
use Livewire\Component;

class Users extends Component
{
    use WithPerPagePagination;

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
            'users' => $this->applyPagination(User::query()->search('name', $this->search)),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
