<?php

namespace App\Http\Livewire\Dashboard\Administration\CustomStyles;

use App\Events\ActionLog;
use App\Models\CustomStyle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomStyleUpdate extends Component
{
    public CustomStyle $customStyle;

    protected $rules = [
        'customStyle.enable_header' => 'required|boolean',
        'customStyle.header' => 'string',
        'customStyle.enable_footer' => 'required|boolean',
        'customStyle.footer' => 'string',
        'customStyle.custom_css' => 'string',
        'customStyle.active' => 'required|boolean',
    ];

    public function mount(CustomStyle $id)
    {
        $this->customStyle = $id;
    }

    public function render()
    {
        return view('livewire.dashboard.administration.custom-styles.custom-style-update');
    }

    public function saveCustomStyle() {
        $this->validate();

        $this->customStyle->save();
        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 2,
            'message' => 'Custom Style (ID: '.$this->customStyle->id.')',
        ));
        $this->redirectRoute('dashboard.admin.custom-styles.list');
    }
}
