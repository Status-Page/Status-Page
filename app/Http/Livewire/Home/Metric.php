<?php

namespace App\Http\Livewire\Home;

use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class Metric extends Component
{
    public \App\Models\Metric $metric;

    public function render()
    {
        $labels = [];
        for($i = 24; $i > 0; $i--){
            array_push($labels, Carbon::now()->subHours($i-1)->setMinutes(intval(Carbon::now()->minute / 5) * 5)->format('H:i'));
        }
        return view('livewire.home.metric', [
            'labels' => json_encode($labels, JSON_NUMERIC_CHECK),
            'data' => json_encode(Cache::remember($this->metric->id.'_points', 60*5, function () {
                return $this->metric->points()->get()->map(function ($point){
                    return $point->value;
                });
            }), JSON_NUMERIC_CHECK)
        ]);
    }
}
