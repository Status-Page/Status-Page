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

class IncidentUpdateUpdateModal extends Component
{
    public bool $modal = false;
    public Incident $incident;
    public IncidentUpdate $incidentUpdate;

    protected $rules = [
        'incidentUpdate.text' => 'required|string|min:3',
    ];

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-update-update-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->incidentUpdate->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Incident Update '.$this->incidentUpdate->id.' from '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
