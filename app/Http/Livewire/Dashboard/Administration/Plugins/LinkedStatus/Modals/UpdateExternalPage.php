<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\LinkedStatus\Modals;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\LinkedStatusProvider;
use App\Models\UptimeRobotMonitor;
use App\Models\User;
use App\Rules\FQDN;
use App\Rules\FQDNResolves;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UpdateExternalPage extends Component
{
    public bool $modal = false;
    public LinkedStatusProvider $page;

    public function render()
    {
        return view('livewire.dashboard.administration.plugins.linked-status.modals.update-external-page');
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page.domain' => ['required', 'string', new FQDN(), new FQDNResolves()],
            'page.provider' => 'required|in:statuspageio',
            'page.create_linked_incidents' => 'boolean',
            'page.create_linked_maintenances' => 'boolean',
        ];
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->page->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'LinkedStatus Page '.$this->page->domain.' (ID: '.$this->page->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
