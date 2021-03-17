<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Livewire\Component;

class IncidentAddModal extends Component
{
    public bool $modal = false;
    public Incident $incident;
    public IncidentUpdate $incidentUpdate;
    public $incidentComponents;
    public bool $doNotUpdateStatus = false;

    protected $rules = [
        'incident.title' => 'required|string|min:3',
        'incident.status' => 'required|integer|min:0|max:3',
        'incident.impact' => 'required|integer|min:0|max:3',
        'incident.visibility' => 'boolean',
        'incidentUpdate.text' => 'required|string|min:3',
        'incidentComponents' => '',
        'doNotUpdateStatus' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-add-modal');
    }

    public function start(){
        $this->incident = new Incident();
        $this->incidentUpdate = new IncidentUpdate();

        $this->incident->status = 0;
        $this->incident->impact = 0;
        $this->incident->visibility = 0;

        $this->modal = true;
    }

    public function save(){
        $this->incident->type = 0;
        $this->incident->user = Auth::id();

        $this->validate();

        $this->incident->save();

        $this->incidentUpdate->incident_id = $this->incident->id;
        $this->incidentUpdate->type = 1;
        $this->incidentUpdate->status = $this->incident->status;
        $this->incidentUpdate->user = Auth::id();

        foreach ($this->incidentComponents as $incidentComponent) {
            if(!$this->incident->components->contains($incidentComponent)){
                $this->incident->components()->attach($incidentComponent);
            }
        }

        if(!$this->doNotUpdateStatus){
            if(0 <= $this->incident->status && $this->incident->status < 3){
                foreach ($this->incident->components()->get() as $component){
                    $component->update([
                        'status_id' => $this->incident->impact+2,
                    ]);
                }
            }
        }

        $this->incidentUpdate->save();
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Incident '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
