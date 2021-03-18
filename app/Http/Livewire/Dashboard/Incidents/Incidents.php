<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Incident;
use Auth;
use Livewire\Component;

class Incidents extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Incidents',
        ));
        return view('livewire.dashboard.incidents.incidents', [
            'incidents' => $this->applyPagination(Incident::query()->where([['status', '!=', 3], ['type', '=', 0]])->search('title', $this->search, [['status', '!=', 3], ['type', '=', 0]])),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
