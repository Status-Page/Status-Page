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

class ComponentGroupUpdateModal extends Component
{
    public bool $modal = false;
    public ComponentGroup $group;

    protected $rules = [
        'group.name' => 'required|string|min:3',
        'group.description' => 'string|min:3',
        'group.visibility' => 'boolean',
        'group.collapse' => 'required|string',
        'group.order' => 'required|integer',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-group-update-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        $this->validate();
        $this->group->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Component Group '.$this->group->name.' (ID: '.$this->group->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
