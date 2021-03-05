<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Components\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use Auth;
use Livewire\Component;

class ComponentAddModal extends Component
{
    public ComponentGroup $group;

    public bool $modal = false;
    public \App\Models\Component $model;

    protected $rules = [
        'model.name' => 'required|string|min:3',
        'model.link' => 'url',
        'model.description' => 'string|min:3',
        'model.status_id' => 'required|integer|min:1|max:6',
        'model.order' => 'integer',
        'model.visibility' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-add-modal');
    }

    public function start(){
        $this->model = new \App\Models\Component();
        $this->model->status_id = 2;
        $this->modal = true;
    }

    public function save(){
        $this->model->group = $this->group->id;
        $this->model->user = Auth::id();

        $this->validate();

        $this->model->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Component '.$this->model->name.' (ID: '.$this->model->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
