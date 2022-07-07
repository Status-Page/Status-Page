<?php

namespace App\Http\Livewire\Dashboard\Administration\AppSettings;

use App\Models\Setting;
use Artisan;
use Crypt;
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
            if($setting['encrypted']){
                Setting::query()->where('key', $setting['key'])->where('value', '<>', $setting['value'])->update([
                    'value' => $setting['value'] == '' ? '' : Crypt::encryptString($setting['value']),
                ]);
                $setting['value'] = Crypt::encryptString($setting['value']);
            }else{
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
        }
        $this->settings = Setting::all()->toArray();

        $this->emit('saved');
    }
}
