<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Components\Modals;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use App\Models\LinkedStatusComponent;
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
        'comp.linked_external_object_id' => 'nullable|integer',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-add-modal');
    }

    public function start(){
        $this->comp = new \App\Models\Component();
        $this->comp->status_id = 2;
        $this->comp->order = 0;
        $this->comp->linked_external_object_id = null;
        $this->comp->linked_status_provider_id = null;
        $this->comp->visibility = false;
        $this->modal = true;
    }

    public function save(){
        $this->comp->group = $this->group->id;
        $this->comp->user = Auth::id();

        if($this->comp->linked_external_object_id == 'None' || !LinkedStatusComponent::query()->where('id', $this->comp->linked_external_object_id)->exists()){
            $this->comp->linked_external_object_id = null;
            $this->comp->linked_status_provider_id = null;
        }

        $this->validate();

        if ($this->comp->linked_external_object_id != null){
            $this->comp->linked_status_provider_id = LinkedStatusComponent::query()->where('id', $this->comp->linked_external_object_id)->first()->linkedStatusProvider()->first()->id;
        }

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
