<?php

namespace App\Http\Livewire\Dashboard\Incidents;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Status;
use Auth;
use Livewire\Component;

class Incidents extends Component
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
            'message' => 'Incidents',
        ));
        return view('livewire.dashboard.incidents.incidents');
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.incidents');
    }
}
