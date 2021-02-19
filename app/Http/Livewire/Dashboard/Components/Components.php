<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Events\ActionLog;
use App\Models\ComponentGroup;
use Auth;
use Livewire\Component;

class Components extends Component
{
    protected $listeners = ['refreshData'];

    /**
     * @var $groups ComponentGroup[]
     */
    public $groups;

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Components',
        ));
        return view('livewire.dashboard.components.components');
    }

    public function refreshData(){
        $this->redirectRoute('dashboard.components');
    }
}
