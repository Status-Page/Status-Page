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
    public $incidentComponents;

    protected $rules = [
        'maintenance.title' => 'required|string|min:3',
        'maintenance.status' => 'required|integer|min:0|max:3',
        'maintenance.visibility' => 'integer|max:1',
        'maintenance.scheduled_at' => 'required|date',
        'maintenanceUpdate.text' => 'required|string|min:3',
        'incidentComponents' => '',
    ];

    public function render()
    {
        return view('livewire.dashboard.maintenances.modals.maintenance-update-modal');
    }

    public function start(){
        $this->maintenanceUpdate = new IncidentUpdate();
        $this->incidentComponents = $this->maintenance->components()->allRelatedIds();

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

        foreach ($this->maintenance->components()->get() as $incidentComponent) {
            $this->maintenance->components()->detach($incidentComponent->id);
        }

        foreach ($this->incidentComponents as $incidentComponent) {
            if(!$this->maintenance->components->contains($incidentComponent)){
                $this->maintenance->components()->attach($incidentComponent);
            }
        }

        if(0 < $this->maintenance->status && $this->maintenance->status < 3){
            foreach ($this->maintenance->components()->get() as $component){
                $component->update([
                    'status_id' => 6,
                ]);
            }
        }

        if($this->maintenance->status == 3){
            foreach ($this->maintenance->components()->get() as $component){
                $component->update([
                    'status_id' => 2,
                ]);
            }
        }

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Maintenance '.$this->maintenance->title.' (ID: '.$this->maintenance->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
