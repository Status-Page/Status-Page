<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Maintenances;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Status;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PastMaintenances extends Component
{
    use WithPagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Past Incidents',
        ));
        return view('livewire.dashboard.maintenances.past-maintenances', [
            'old_maintenances' => Incident::query()->where([['status', '=', 3], ['type', '=', 1]])->search('title', $this->search, [['status', '=', 3], ['type', '=', 1]])->paginate(),
        ]);
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.incidents.past');
    }
}
