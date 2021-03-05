<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Administration\Modals;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\User;
use Auth;
use Livewire\Component;

class UserDeleteModal extends Component
{
    public User $user;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.administration.modals.user-delete-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'User '.$this->user->name.' (ID: '.$this->user->id.')',
        ));

        $this->user->roles()->detach();
        $this->user->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
