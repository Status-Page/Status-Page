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

class ComponentGroupAddModal extends Component
{
    public ComponentGroup $newGroup;
    public $groupCreationModal = false;

    protected $rules = [
        'newGroup.name' => 'required|string|min:3',
        'newGroup.order' => 'required|integer',
        'newGroup.visibility' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-group-add-modal');
    }

    public function startAddGroup(){
        $this->newGroup = new ComponentGroup();
        $this->groupCreationModal = true;
    }
    public function addGroup(){
        if(!$this->newGroup->visibility){
            $this->newGroup->visibility = 0;
        }
        $this->newGroup->user = Auth::id();

        $this->validate();

        $this->newGroup->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Component Group '.$this->newGroup->name.' (ID: '.$this->newGroup->id.')',
        ));


        $this->groupCreationModal = false;
        $this->emitUp('refreshData');
    }
}
