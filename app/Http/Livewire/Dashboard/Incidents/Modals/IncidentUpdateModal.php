<?php

namespace App\Http\Livewire\Dashboard\Incidents\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use Auth;
use Livewire\Component;

class IncidentUpdateModal extends Component
{
    public bool $modal = false;
    public Incident $model;
    public IncidentUpdate $modelUpdate;

    protected $rules = [
        'model.title' => 'required|string|min:3',
        'model.status' => 'required|integer|min:0|max:3',
        'model.impact' => 'required|integer|min:0|max:3',
        'model.visibility' => 'integer|max:1',
        'modelUpdate.text' => 'required|string|min:3',
    ];

    public function render()
    {
        return view('livewire.dashboard.incidents.modals.incident-update-modal');
    }

    public function start(){
        $this->modelUpdate = new IncidentUpdate();

        $this->modal = true;
    }

    public function save(){
        $oldIncident = Incident::query()->where('id', '=', $this->model->id)->first();

        $this->model->type = 0;

        $this->validate();

        $this->model->save();

        $this->modelUpdate->incident_id = $this->model->id;
        $this->modelUpdate->type = $oldIncident->status == $this->model->status ? 0 : 1;
        $this->modelUpdate->status = $this->model->status;
        $this->modelUpdate->user = Auth::id();

        $this->modelUpdate->save();
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Incident '.$this->model->title.' (ID: '.$this->model->id.')',
        ));
        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
