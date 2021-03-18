<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Http\Livewire\Dashboard\Components;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\ComponentGroup;
use Auth;
use Livewire\Component;

class Components extends Component
{
    use WithPerPagePagination;

    protected $listeners = ['refreshData'];

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Components',
        ));
        return view('livewire.dashboard.components.components', [
            'groups' => $this->applyPagination(ComponentGroup::query()->orderBy('order')),
        ]);
    }

    public function changeVisibility($id, $oldVis){
        ComponentGroup::query()->where('id', '=', $id)->update([
            'visibility' => $oldVis == 0 ? 1 : 0,
        ]);

        $group = ComponentGroup::query()->where('id', '=', $id)->first();

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Component Group '.$group->name.' (ID: '.$group->id.')',
        ));

        $this->refreshData();
    }

    public function refreshData(){
        // Placeholder
    }
}
