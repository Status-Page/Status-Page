<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class Metric extends Component
{
    protected $listeners = ['update'];
    protected $queryString = ['interval'];

    public \App\Models\Metric $metric;
    private object $metricData;
    public $intervalSelect = 60;
    public $interval;

    public function render()
    {
        $this->metricData = $this->metric->getIntervalPointsLastHours(24, $this->interval ?? 60);

        return view('livewire.home.metric', [
            'labels' => json_encode($this->metricData->labels, JSON_NUMERIC_CHECK),
            'data' => json_encode($this->metricData->points, JSON_NUMERIC_CHECK)
        ]);
    }

    public function update(){
        $this->redirectRoute('home', [
            'interval' => $this->intervalSelect,
        ]);
    }
}
