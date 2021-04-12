<?php

namespace App\Http\Livewire\Dashboard\Metrics\Modals;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\Metric;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class MetricUpdateModal extends Component
{
    use PasswordValidationRules;

    public bool $modal = false;
    public Metric $metric;
    protected array $rules = [
        'metric.title' => 'string|min:3|max:255',
        'metric.suffix' => 'string|max:255',
        'metric.order' => 'integer',
        'metric.visibility' => 'boolean',
        'metric.collapse' => 'string',
    ];

    public function render()
    {
        return view('livewire.dashboard.metrics.modals.metric-update-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->metric->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Metric '.$this->metric->title.' (ID: '.$this->metric->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
