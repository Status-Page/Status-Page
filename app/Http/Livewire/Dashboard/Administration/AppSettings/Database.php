<?php

namespace App\Http\Livewire\Dashboard\Administration\AppSettings;

use App\Models\Setting;
use Artisan;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Database extends Component
{
    protected $listeners = ['refreshData'];

    public $settings = [];

    public function mount(){
        $this->settings = Setting::all()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.administration.app-settings.database');
    }

    public function updateInformation(){
        foreach ($this->settings as $setting){
            if($setting['type'] == 'checkbox'){
                Setting::query()->where('key', $setting['key'])->update([
                    'boolval' => boolval($setting['boolval']),
                ]);
            }else{
                Setting::query()->where('key', $setting['key'])->update([
                    'value' => $setting['value'],
                ]);
            }
        }
        $this->emit('saved');
    }
}
