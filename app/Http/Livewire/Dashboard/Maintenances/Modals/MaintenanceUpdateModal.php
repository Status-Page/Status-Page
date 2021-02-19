<?php

namespace App\Http\Livewire\Dashboard\Maintenances\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Livewire\Component;

class MaintenanceUpdateModal extends Component
{
    public bool $modal = false;
    public Incident $maintenance;
    public IncidentUpdate $maintenanceUpdate;

    protected $rules = [
        'maintenance.title' => 'required|string|min:3',
        'maintenance.status' => 'required|integer|min:0|max:3',
        'maintenance.visibility' => 'integer|max:1',
        'maintenanceUpdate.text' => 'required|string|min:3',
    ];

    public function render()
    {
        return view('livewire.dashboard.maintenances.modals.maintenance-update-modal');
    }

    public function start(){
        $this->maintenanceUpdate = new IncidentUpdate();

        $this->modal = true;
    }

    public function save(){
        $oldIncident = Incident::query()->where('id', '=', $this->maintenance->id)->first();

        $this->maintenance->type = 1;

        $this->validate();

        $this->maintenance->save();

        $this->maintenanceUpdate->incident_id = $this->maintenance->id;
        $this->maintenanceUpdate->type = $oldIncident->status == $this->maintenance->status ? 0 : 1;
        $this->maintenanceUpdate->status = $this->maintenance->status;
        $this->maintenanceUpdate->user = Auth::id();

        $this->maintenanceUpdate->save();
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Maintenance '.$this->maintenance->title.' (ID: '.$this->maintenance->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
