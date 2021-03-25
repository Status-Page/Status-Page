<?php

namespace App\Http\Livewire\Home;

use App\Models\Setting;
use Cache;
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
            'metricData' => Setting::getBoolean('metrics_cache')
                            ? Cache::get('metric_'.$this->metric->id.'_'.($this->lastHours ?? 24).'_'.($this->interval ?? 60), $this->getMetricData())
                            : $this->getMetricData(),
        ]);
    }

    public function updated(){
        $this->dispatchBrowserEvent('refreshJavaScript-'.$this->metric->id);
    }

    public function getMetricData(){
        return $this->metric->getIntervalPointsLastHours($this->lastHours ?? 24, $this->interval ?? 60);
    }
}
