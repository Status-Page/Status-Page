<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Maintenances\Modals;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Livewire\Component;

class MaintenanceUpdateDeleteModal extends Component
{
    public Incident $maintenance;
    public IncidentUpdate $maintenanceUpdate;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.maintenances.modals.maintenance-update-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Incident Update '.$this->maintenanceUpdate->id.' from '.$this->maintenance->title.' (ID: '.$this->maintenance->id.')',
        ));
        $this->maintenanceUpdate->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
