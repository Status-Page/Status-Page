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

class Past extends Component
{
    protected $listeners = ['refreshData'];

    /**
     * @var $incidents Incident[]
     */
    public $incidents;

    /**
     * @var $oldincidents Incident[]
     */
    public $oldincidents;

    /**
     * @var $oldmaintenances Incident[]
     */
    public $oldmaintenances;

    /**
     * @var $maintenances Incident[]
     */
    public $maintenances;

    /**
     * @var $upcomingmaintenances Incident[]
     */
    public $upcomingmaintenances;

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Past Incidents',
        ));
        return view('livewire.dashboard.incidents.past');
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.incidents.past');
    }
}
