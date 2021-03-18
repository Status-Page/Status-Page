<?php

namespace App\Http\Livewire\Dashboard\Metrics;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Metric;
use Auth;
use Livewire\Component;

class Metrics extends Component
{
    use WithPerPagePagination;

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
            'metrics' => $this->applyPagination(Metric::query()->orderBy('order')->search('title', $this->search, [], 'order')),
        ]);
    }

    public function reorder($orderedIds)
    {
        dd($orderedIds);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function refreshData(){
        // Placeholder
    }
}
