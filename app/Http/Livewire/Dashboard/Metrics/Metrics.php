<?php

namespace App\Http\Livewire\Dashboard\Metrics;

use App\Events\ActionLog;
use App\Models\Metric;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Metrics extends Component
{
    use WithPagination;

    protected $listeners = ['refreshData'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Metrics',
        ));

        return view('livewire.dashboard.metrics.metrics', [
            'metrics' => Metric::query()->orderBy('order')->search('title', $this->search, [], 'order')->paginate(),
        ]);
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.metrics');
    }
}
