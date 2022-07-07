<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\UptimeRobot;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\UptimeRobotMonitor;
use Auth;
use Livewire\Component;

class Monitors extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData' => '$refresh'];

    public $search = '';

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'UptimeRobot Monitors',
        ));

        return view('livewire.dashboard.administration.plugins.uptime-robot.monitors', [
            'monitors' => $this->applyPagination(UptimeRobotMonitor::query()->search('friendly_name', $this->search)),
        ]);
    }

    public function changePause($id, $oldPause){
        UptimeRobotMonitor::query()->where('id', '=', $id)->update([
            'paused' => $oldPause == 0 ? 1 : 0,
        ]);

        $monitor = UptimeRobotMonitor::query()->where('id', '=', $id)->first();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'UptimeRobot Monitor '.$monitor->friendly_name.' (ID: '.$monitor->id.')',
        ));
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function reload(){
    }
}
