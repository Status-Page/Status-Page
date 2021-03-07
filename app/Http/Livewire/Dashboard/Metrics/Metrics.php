<?php

namespace App\Http\Livewire\Dashboard\Metrics;

use App\Events\ActionLog;
use App\Models\Metric;
use Auth;
use Livewire\Component;

class Metrics extends Component
{
    protected $listeners = ['refreshData'];

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Metrics',
        ));

        return view('livewire.dashboard.metrics.metrics', [
            'metrics' => Metric::query()->orderBy('order')->get(),
        ]);
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.metrics');
    }
}
