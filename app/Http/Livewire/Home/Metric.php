<?php

namespace App\Http\Livewire\Home;

use Cache;
use Livewire\Component;

class Metric extends Component
{
    protected $listeners = ['update'];

    public \App\Models\Metric $metric;
    public $lastHours;

    public function render()
    {
        return view('livewire.home.metric', [
            'metricData' => $this->getMetricData(),
        ]);
    }

    public function updated(){
        $this->dispatchBrowserEvent('refreshJavaScript-'.$this->metric->id);
    }

    public function getMetricData(){
        switch ($this->lastHours){
            case 105:
                return $this->metric->getPointsSinceMinutes(30);
            case 1:
                return $this->metric->getPointsSinceMinutes(60);
            case 12:
                return $this->metric->getPointsSinceHours(12);
            case 24:
                return $this->metric->getPointsSinceHours(24);
            case 48:
                return $this->metric->getPointsSinceHours(48);
            case 72:
                return $this->metric->getPointsSinceHours(72);
            case 168:
                return $this->metric->getPointsSinceDays(7);
            case 720:
                return $this->metric->getPointsSinceDays(30);
        }
    }
}
