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

class IncidentUpdateModal extends Component
{
    public bool $modal = false;
    public Incident $incident;
    public IncidentUpdate $incidentUpdate;
    public $incidentComponents;

    protected $rules = [
        'incident.title' => 'required|string|min:3',
        'incident.status' => 'required|integer|min:0|max:3',
        'incident.impact' => 'required|integer|min:0|max:3',
        'incident.visibility' => 'boolean',
        'incidentUpdate.text' => 'required|string|min:3',
        'incidentComponents' => '',
    ];

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-update-modal');
    }

    public function start(){
        $this->incidentUpdate = new IncidentUpdate();
        $this->incidentComponents = $this->incident->components()->allRelatedIds();

        $this->modal = true;
    }

    public function save(){
        $oldIncident = Incident::query()->where('id', '=', $this->incident->id)->first();

        $this->incident->type = 0;

        $this->validate();

        $this->incident->save();

        $this->incidentUpdate->incident_id = $this->incident->id;
        $this->incidentUpdate->type = $oldIncident->status == $this->incident->status ? 0 : 1;
        $this->incidentUpdate->status = $this->incident->status;
        $this->incidentUpdate->user = Auth::id();
        $this->incidentUpdate->save();

        }

        $this->incident->components()->detach();
        $this->incident->components()->attach($this->incidentComponents);

        if($this->incident->status == 3){
            foreach ($this->incident->components()->get() as $component){
                $component->update([
                    'status_id' => 2,
                ]);
            }
        }

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Incident '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
