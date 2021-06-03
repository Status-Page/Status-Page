<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\LinkedStatus\Modals;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\LinkedStatusProvider;
use App\Models\UptimeRobotMonitor;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

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
