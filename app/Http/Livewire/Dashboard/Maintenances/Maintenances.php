<?php

namespace App\Http\Livewire\Dashboard\Maintenances;

use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Status;
use Auth;
use Livewire\Component;

class Maintenances extends Component
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

    public $incidentDeletionModal = false;
    public $incidentUpdateModal = false;

    public Incident $oldIncident;
    public Incident $newIncident;
    public IncidentUpdate $newIncidentUpdate;

    protected $rules = [
        'newIncident.title' => 'required|string|min:6',
        'newIncident.status' => 'required|string|max:1',
        'newIncident.impact' => 'required|string|max:1',
        'newIncident.visible' => 'required|string|max:1',
        'newIncident.scheduled_at' => 'required',
        'newIncidentUpdate.text' => 'required|string|min:6',
    ];

    public function render()
    {
        return view('livewire.dashboard.maintenances.maintenances');
    }

    public function startDeleteIncident(){
        $this->incidentDeletionModal = true;
    }

    public function deleteIncident($id){
        IncidentUpdate::query()->where('incident_id', '=', $id)->delete();

        Incident::find($id)->delete();
        $this->incidentDeletionModal = false;
        $this->incidents = Incident::getIncidents();
    }

    public function startUpdateIncident($id){
        $this->oldIncident = Incident::query()->where('id', '=', $id)->first();
        $this->newIncident = Incident::query()->where('id', '=', $id)->first();
        $this->newIncidentUpdate = new IncidentUpdate();

        $this->incidentUpdateModal = true;
    }

    public function updateIncident(){
        if(!$this->newIncident->title){
            $this->reset('newIncident');
            return;
        }
        if(!$this->newIncident->status){
            $this->newIncident->status = 0;
        }
        if(!$this->newIncident->visible){
            $this->newIncident->visible = 0;
        }

        $this->newIncident->save();

        $this->newIncidentUpdate->incident_id = $this->newIncident->id;
        $this->newIncidentUpdate->type = $this->oldIncident->status == $this->newIncident->status ? 0 : 1;
        $this->newIncidentUpdate->status = $this->newIncident->status;
        $this->newIncidentUpdate->user = Auth::id();

        $this->newIncidentUpdate->save();
        $this->incidentUpdateModal = false;
        $this->maintenances = Incident::getMaintenances();
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.incidents.maintenances');
    }
}
