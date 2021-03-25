<?php

namespace App\Http\Livewire\Home;

use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\Setting;
use App\Models\Status;
use Cache;
use Livewire\Component;
use \App\Models\Metric;
use Session;

class Home extends Component
{
    public $interval = 60;
    public $lastHours = 24;

    public bool $readyToLoad = false;

    public function render()
    {
        return view('livewire.home.home', [
            'metric_count' => Metric::query()->where('visibility', true)->count(),
            'metrics' => $this->readyToLoad
                ? Metric::query()->where('visibility', true)->orderBy('order')->get()
                : [],
            'component_groups' => Cache::remember('home_componentgroups', config('cache.ttl'), function (){
                return ComponentGroup::getGroups();
            }),
            'upcoming_maintenances' => Incident::query()->where([['status', '=', 0], ['type', '=', 1], ['visibility', '=', true]])->get(),
            'incidents' => Cache::remember('home_incidents', config('cache.ttl'), function (){
                return Incident::query()->where([['status', '!=', 3], ['type', '=', 0], ['visibility', '=', true]])->orWhere([['status', '!=', 3], ['type', '=', 1], ['status', '!=', 0], ['visibility', '=', true]])->orderBy('id', 'desc')->get();
            }),
            'globalStatus' => $this->getGlobalStatus(),
        ])->layout('layouts.guest');
    }

    public function mount(){
        $this->interval = Session::get('interval', $this->interval);
        $this->lastHours = Session::get('lastHours', $this->lastHours);
    }

    public function updatedInterval(){
        Session::put('interval', $this->interval);
    }

    public function updatedLastHours(){
        Session::put('lastHours', $this->lastHours);
    }

    public function loadData(){
        $this->readyToLoad = true;
    }

    public function changeDarkmode(){
        session()->put('darkmode', !session()->get('darkmode', Setting::getBoolean('darkmode_default')));
        $this->redirectRoute('home');
    }

    private function getGlobalStatus(){
        $components = Cache::remember('home_components', config('cache.ttl'), function (){
            return \App\Models\Component::all();
        });

        $highestStatus = 1;
        $globalStatus = Status::getByOrder($highestStatus)->first();
        foreach ($components as $component){
            if($component->group()->visibility == 1){
                if($highestStatus < $component->status()->id){
                    $highestStatus = $component->status()->id;
                    $globalStatus = $component->status();
                }
            }
        }

        return $globalStatus;
    }
}
