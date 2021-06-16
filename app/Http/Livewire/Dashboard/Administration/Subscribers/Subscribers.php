<?php

namespace App\Http\Livewire\Dashboard\Administration\Subscribers;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Subscriber;
use Auth;
use Livewire\Component;

class Subscribers extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Subscribers',
        ));

        return view('livewire.dashboard.administration.subscribers.subscribers', [
            'subscribers' => $this->applyPagination(Subscriber::query()->search('email', $this->search)),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
