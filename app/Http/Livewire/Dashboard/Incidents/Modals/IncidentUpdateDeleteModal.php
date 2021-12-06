<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents\Modals;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Livewire\Component;

class IncidentUpdateDeleteModal extends Component
{
    public Incident $incident;
    public IncidentUpdate $incidentUpdate;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-update-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Incident Update '.$this->incidentUpdate->id.' from '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        $this->incidentUpdate->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
