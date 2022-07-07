<?php

namespace App\Http\Livewire\Dashboard\Administration\AppSettings;

use Artisan;
use Livewire\Component;

class General extends Component
{
    public string $app_name;
    public string $app_url;
    public string $app_locale;

    protected $listeners = ['refreshData'];

    public function render()
    {
        $this->loadData();
        return view('livewire.dashboard.administration.app-settings.general');
    }

    public function updateInformation(){
        $this->updateEnv('app.name', $this->app_name);
        $this->updateEnv('app.url', $this->app_url);
        $this->updateEnv('app.locale', $this->app_locale);

        Artisan::call(config('app.env') == 'production' ? 'config:cache' : 'config:clear');
        $this->redirectRoute('dashboard.admin.settings');
    }

    private function loadData(){
        $this->app_name = config('app.name');
        $this->app_url = config('app.url');
        $this->app_locale = config('app.locale');
    }

    private function updateEnv(string $key, $value){
        $path = base_path('.env');
        $configKey = str_replace('.', '_', strtoupper($key));

        $oldValue = config($key);

        if (file_exists($path)) {
            if(str_contains($oldValue, ' ')){
                $oldValue = '"'.$oldValue.'"';
            }
            if(str_contains($value, ' ')){
                $value = '"'.$value.'"';
            }
            file_put_contents($path, str_replace(
                $configKey.'='.$oldValue, $configKey.'='.$value, file_get_contents($path)
            ));
        }
    }
}
