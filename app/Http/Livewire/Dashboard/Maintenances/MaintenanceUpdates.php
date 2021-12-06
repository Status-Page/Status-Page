<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Maintenances;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Incident;
use Auth;
use Livewire\Component;

class MaintenanceUpdates extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public Incident $maintenance;

    public $search = '';

    public function mount($id)
    {
        $this->maintenance = Incident::find($id);
    }

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Maintenance Updates for '.$this->maintenance->title.' (ID: '.$this->maintenance->id.')',
        ));
        return view('livewire.dashboard.maintenances.maintenance-updates', [
            'maintenanceUpdates' => $this->applyPagination($this->maintenance->incidentUpdates()),
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
