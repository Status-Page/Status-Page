<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Metrics\Modals;

use App\Events\ActionLog;
use App\Models\Incident;
use App\Models\Metric;
use App\Models\User;
use Auth;
use Livewire\Component;

class MetricDeletePointsModal extends Component
{
    public Metric $metric;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.dashboard.metrics.modals.metric-delete-points-modal');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Metric Points '.$this->metric->title.' (ID: '.$this->metric->id.')',
        ));

        $this->metric->points()->delete();

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
