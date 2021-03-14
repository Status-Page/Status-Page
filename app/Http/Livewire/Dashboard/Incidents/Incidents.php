<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Status;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Incidents extends Component
{
    use WithPagination;

    protected $listeners = ['refreshData'];

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Incidents',
        ));
        return view('livewire.dashboard.incidents.incidents', [
            'incidents' => Incident::getIncidents()
        ]);
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.incidents');
    }
}
