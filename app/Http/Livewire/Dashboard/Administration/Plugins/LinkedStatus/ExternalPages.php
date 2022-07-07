<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\LinkedStatus;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\LinkedStatusProvider;
use Auth;
use Livewire\Component;

class ExternalPages extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData' => '$refresh'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'LinkedStatus Pages',
        ));

        return view('livewire.dashboard.administration.plugins.linked-status.external-pages', [
            'pages' => $this->applyPagination(LinkedStatusProvider::query()->search('domain', $this->search)),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function reload(){
    }
}
