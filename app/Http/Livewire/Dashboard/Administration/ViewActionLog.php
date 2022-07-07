<?php

namespace App\Http\Livewire\Dashboard\Administration;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Action;
use Auth;
use Livewire\Component;

class ViewActionLog extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        return view('livewire.dashboard.administration.view-action-log', [
            'logs' => $this->applyPagination(Action::query()->orderBy('id', 'desc')->search('message', $this->search)),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
