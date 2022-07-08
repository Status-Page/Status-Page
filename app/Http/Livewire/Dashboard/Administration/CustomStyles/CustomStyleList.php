<?php

namespace App\Http\Livewire\Dashboard\Administration\CustomStyles;

use App\Events\ActionLog;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\CustomStyle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomStyleList extends Component
{
    use WithPerPagePagination;

    public function render()
    {
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 0,
            'message' => 'Custom Styles',
        ));

        return view('livewire.dashboard.administration.custom-styles.custom-style-list', [
            'custom_styles' => $this->applyPagination(CustomStyle::query()),
        ]);
    }

    public function addCustomStyle(){
        $this->redirectRoute('dashboard.admin.custom-styles.create');
    }

    public function toggleCustomStyle(CustomStyle $customStyle){
        $customStyle->active = !$customStyle->active;
        $customStyle->save();
        $this->emit('refreshComponent');
    }

    public function updateCustomStyle(CustomStyle $customStyle){
        $this->redirectRoute('dashboard.admin.custom-styles.update', [
            'id' => $customStyle->id,
        ]);
    }

    public function deleteCustomStyle(CustomStyle $customStyle){
        $customStyle->delete();
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 3,
            'message' => 'Custom Style (ID: '.$customStyle->id.')',
        ));
        $this->emit('refreshComponent');
    }
}
