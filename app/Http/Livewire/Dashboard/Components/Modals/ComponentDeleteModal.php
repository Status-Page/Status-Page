<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Components\Modals;

use App\Events\ActionLog;
use Auth;
use Livewire\Component;

class ComponentDeleteModal extends Component
{
    public \App\Models\Component $comp;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.components.modals.component-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Component '.$this->comp->name.' (ID: '.$this->comp->id.')',
        ));


        $this->comp->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
