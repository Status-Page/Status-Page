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

class IncidentUpdates extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public Incident $incident;

    public $search = '';

    public function mount($id)
    {
        $this->incident = Incident::find($id);
    }

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Incident Updates for '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        return view('livewire.dashboard.incidents.incident-updates', [
            'incidentUpdates' => $this->applyPagination($this->incident->incidentUpdates()),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
