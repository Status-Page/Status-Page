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

class ComponentUpdateModal extends Component
{
    public ComponentGroup $group;

    public bool $modal = false;
    public \App\Models\Component $comp;

    protected $rules = [
        'comp.name' => 'required|string|min:3',
        'comp.link' => 'url',
        'comp.description' => 'string|min:3',
        'comp.group' => 'required|integer',
        'comp.status_id' => 'required|integer|min:1|max:6',
        'comp.order' => 'required|integer',
        'comp.visibility' => 'boolean',
        'comp.linked_external_object_id' => 'nullable|integer',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-update-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
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
            'type' => 2,
            'message' => 'Component '.$this->comp->name.' (ID: '.$this->comp->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
