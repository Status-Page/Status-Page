<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Maintenances\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MaintenanceAddModal extends Component
{

    public bool $modal = false;
    public Incident $incident;
    public IncidentUpdate $incidentUpdate;
    public $incidentComponents;

    protected $rules = [
        'incident.title' => 'required|string|min:3',
        'incident.visibility' => 'boolean',
        'incident.scheduled_at' => 'required|date',
        'incident.end_at' => 'date',
        'incidentUpdate.text' => 'required|string|min:3',
        'incidentComponents' => '',
    ];

    public function render()
    {
        return view('livewire.dashboard.maintenances.modals.maintenance-add-modal');
    }

    public function start(){
        $this->incident = new Incident();
        $this->incidentUpdate = new IncidentUpdate();

        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->incident->type = 1;
        $this->incident->status = 0;
        $this->incident->impact = 4;
        $this->incident->user = Auth::id();
        $this->incident->save();

        $this->incidentUpdate->incident_id = $this->incident->id;
        $this->incidentUpdate->type = 1;
        $this->incidentUpdate->status = $this->incident->status;
        $this->incidentUpdate->user = Auth::id();
        $this->incidentUpdate->save();

        $this->incident->components()->attach($this->incidentComponents);

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Maintenance '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
