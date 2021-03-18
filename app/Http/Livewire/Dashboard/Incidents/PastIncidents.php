<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Incidents;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Incident;
use Auth;
use Livewire\Component;

class PastIncidents extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Past Incidents',
        ));
        return view('livewire.dashboard.incidents.past-incidents', [
            'old_incidents' => $this->applyPagination(Incident::query()->where([['status', '=', 3], ['type', '=', 0]])->search('title', $this->search, [['status', '=', 3], ['type', '=', 0]])),
        ]);
    }

    public function refreshData(){
        // Placeholder
    }
}
