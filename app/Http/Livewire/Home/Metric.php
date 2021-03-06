<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class Metric extends Component
{
    protected $listeners = ['update'];

    public \App\Models\Metric $metric;
    private object $metricData;
    public $unit = "24";

    public function render()
    {
        $this->metricData = $this->metric->getPointsLastHours(intval($this->unit));

        return view('livewire.home.metric', [
            'labels' => json_encode($this->metricData->labels, JSON_NUMERIC_CHECK),
            'data' => json_encode($this->metricData->points, JSON_NUMERIC_CHECK)
        ]);
    }

    public function update(){
        $this->metricData = $this->metric->getPointsLastHours(intval($this->unit));
    }
}
