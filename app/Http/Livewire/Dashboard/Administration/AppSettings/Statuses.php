<?php

namespace App\Http\Livewire\Dashboard\Administration\AppSettings;

use App\Models\Status;
use Livewire\Component;

class Statuses extends Component
{
    protected $listeners = ['refreshData'];

    public array $statuses = [];

    public function mount(){
        $this->statuses = Status::all()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.administration.app-settings.statuses');
    }

    public function updateInformation(){
        foreach ($this->statuses as $s){
            $status = Status::query()->where('id', $s['id'])->first();
            $status->update([
                'name' => $s['name'],
                'long_description' => $s['long_description']
            ]);
        }

        $this->statuses = Status::all()->toArray();

        $this->emit('saved');
    }

    public function resetNameToDefault(Status $status){
        $status->name = $status->getDefaultName();
        $status->save();

        $this->statuses = Status::all()->toArray();
        $this->updateInformation();
    }

    public function resetLongDescriptionToDefault(Status $status){
        $status->long_description = $status->getDefaultLongDescription();
        $status->save();

        $this->statuses = Status::all()->toArray();
        $this->updateInformation();
    }
}
