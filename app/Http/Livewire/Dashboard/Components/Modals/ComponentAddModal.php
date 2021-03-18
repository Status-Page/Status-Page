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
    public \App\Models\Component $comp;

    protected $rules = [
        'comp.name' => 'required|string|min:3',
        'comp.link' => 'url',
        'comp.description' => 'string|min:3',
        'comp.status_id' => 'required|integer|min:1|max:6',
        'comp.order' => 'integer',
        'comp.visibility' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-add-modal');
    }

    public function start(){
        $this->comp = new \App\Models\Component();
        $this->comp->status_id = 2;
        $this->comp->order = 0;
        $this->modal = true;
    }

    public function save(){
        $this->comp->group = $this->group->id;
        $this->comp->user = Auth::id();

        $this->validate();

        $this->comp->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Component '.$this->comp->name.' (ID: '.$this->comp->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
