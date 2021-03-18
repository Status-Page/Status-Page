<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class Metric extends Component
{
    protected $listeners = ['update'];

    public \App\Models\Metric $metric;
    public $interval;
    public $lastHours;

    public function render()
    {
        return view('livewire.home.metric', [
            'metricData' => $this->metric->getIntervalPointsLastHours($this->lastHours ?? 24, $this->interval ?? 60),
        ]);
    }

    public function updated(){
        $this->dispatchBrowserEvent('refreshJavaScript-'.$this->metric->id);
    }
}
