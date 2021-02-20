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

class ComponentGroupDeleteModal extends Component
{
    public ComponentGroup $group;
    public $groupDeletionModal = false;

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-group-delete-modal');
    }

    public function startDeleteGroup(){
        $this->groupDeletionModal = true;
    }

    public function deleteGroup(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Component Group '.$this->group->name.' (ID: '.$this->group->id.')',
        ));

        \App\Models\Component::query()->where('group', '=', $this->group->id)->delete();
        $this->group->delete();

        $this->groupDeletionModal = false;
        $this->emitUp('refreshData');
    }
}
