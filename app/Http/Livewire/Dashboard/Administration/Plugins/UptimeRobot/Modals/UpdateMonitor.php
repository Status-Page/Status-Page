<?php

namespace App\Http\Livewire\Dashboard\Administration\Plugins\UptimeRobot\Modals;

use App\Events\ActionLog;
use App\Models\UptimeRobotMonitor;
use Auth;
use Hash;
use Livewire\Component;

class UpdateMonitor extends Component
{
    public bool $modal = false;
    public UptimeRobotMonitor $monitor;

    protected $rules = [
        'monitor.component_id' => 'nullable|integer',
        'monitor.metric_id' => 'nullable|integer',
    ];

    public function render()
    {
        return view('livewire.dashboard.administration.plugins.uptime-robot.modals.update-monitor');
    }

    public function start(){
        $this->modal = true;
    }

    public function save(){
        if($this->monitor->component_id == 'None')
            $this->monitor->component_id = null;

        if($this->monitor->metric_id == 'None')
            $this->monitor->metric_id = null;

        $this->validate();

        $this->monitor->save();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'UptimeRobot Monitor '.$this->monitor->friendly_name.' (ID: '.$this->monitor->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
