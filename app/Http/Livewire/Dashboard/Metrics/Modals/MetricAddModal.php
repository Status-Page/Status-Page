<?php

namespace App\Http\Livewire\Dashboard\Metrics\Modals;

use App\Events\ActionLog;
use App\Models\Metric;
use Auth;
use Hash;
use Livewire\Component;

class MetricAddModal extends Component
{
    public bool $modal = false;
    public Metric $metric;
    protected array $rules = [
        'metric.title' => 'required|string|min:3|max:255',
        'metric.suffix' => 'string|max:255',
        'metric.order' => 'integer',
        'metric.visibility' => 'boolean',
        'metric.collapse' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.dashboard.metrics.modals.metric-add-modal');
    }

    public function start(){
        $this->metric = new Metric();
        $this->metric->suffix = '';
        $this->metric->order = 0;
        $this->metric->visibility = false;
        $this->metric->collapse = 'expand_always';

        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->metric->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'Metric '.$this->metric->title.' (ID: '.$this->metric->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
