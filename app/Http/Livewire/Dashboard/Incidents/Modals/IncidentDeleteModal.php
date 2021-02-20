<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents\Modals;

use App\Events\ActionLog;
use App\Models\Incident;
use Auth;
use Livewire\Component;

class IncidentDeleteModal extends Component
{
    public Incident $incident;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Incident '.$this->incident->title.' (ID: '.$this->incident->id.')',
        ));
        $this->incident->incidentUpdates()->delete();

        $this->incident->components()->detach();

        $this->incident->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
