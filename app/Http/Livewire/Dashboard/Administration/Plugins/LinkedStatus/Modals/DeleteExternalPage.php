<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\LinkedStatus\Modals;

use App\Events\ActionLog;
use App\Models\LinkedStatusProvider;
use Auth;
use Hash;
use Livewire\Component;

class DeleteExternalPage extends Component
{
    public bool $modal = false;
    public LinkedStatusProvider $page;

    public function render()
    {
        return view('livewire.dashboard.administration.plugins.linked-status.modals.delete-external-page');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'LinkedStatus Page '.$this->page->domain.' (ID: '.$this->page->id.')',
        ));

        $this->page->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
