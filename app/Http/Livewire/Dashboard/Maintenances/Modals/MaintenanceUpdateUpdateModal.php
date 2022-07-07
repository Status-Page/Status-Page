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

class MaintenanceUpdateUpdateModal extends Component
{
    public bool $modal = false;
    public Incident $maintenance;
    public IncidentUpdate $maintenanceUpdate;

    protected $rules = [
        'maintenanceUpdate.text' => 'required|string|min:3',
    ];

    public function render()
    {
        return view('livewire.dashboard.maintenances.modals.maintenance-update-update-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->maintenanceUpdate->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Maintenance Update '.$this->maintenanceUpdate->id.' from '.$this->maintenance->title.' (ID: '.$this->maintenance->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
