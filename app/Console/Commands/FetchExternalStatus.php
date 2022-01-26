<?php

namespace App\Console\Commands;

use App\Models\LinkedStatusComponent;
use App\Models\LinkedStatusIncident;
use App\Models\LinkedStatusProvider;
use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class FetchExternalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:fetchexternalstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Data form external Sources';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $comp_table = (new LinkedStatusComponent())->getTable();
        DB::table($comp_table)->update(['available' => false]);

        $inc_table = (new LinkedStatusIncident())->getTable();
        DB::table($inc_table)->update(['available' => false]);

        $providers = LinkedStatusProvider::all();
        foreach ($providers as $provider){
            if($this->resolves($provider->domain)){
                switch ($provider->provider){
                    case 'statuspageio':
                        /*
                         * |----------------------
                         * | Components
                         * |----------------------
                         */
                        $response_body = json_decode(Http::get('https://'.$provider->domain.'/api/v2/components.json')->body());
                        $components = $response_body->components;

                        $groups = [];

                        foreach ($components as $component) {
                            if($component->group){
                                $groups[$component->id] = $component;
                            }
                        }

                        foreach ($components as $component) {
                            if(!$component->group){
                                if(LinkedStatusComponent::hasExternalComponent($component->id, $provider->id)){
                                    /**
                                     * @var $comp LinkedStatusComponent|Builder
                                     */
                                    $comp = LinkedStatusComponent::query()->where('external_id', $component->id)->where('linked_status_provider_id', $provider->id)->first();
                                    $comp->name = $component->name;
                                    if($component->group_id != null){
                                        $comp->group_name = $groups[$component->group_id]->name;
                                    }
                                    $comp->available = true;
                                    $comp->save();
                                }else{
                                    $comp = new LinkedStatusComponent();
                                    $comp->external_id = $component->id;
                                    $comp->linked_status_provider_id = $provider->id;
                                    $comp->name = $component->name;
                                    if($component->group_id != null){
                                        $comp->group_name = $groups[$component->group_id]->name;
                                    }
                                    $comp->save();
                                }

                                $components_to_update = $provider->components()->where('linked_external_object_id', $comp->id)->get();
                                foreach ($components_to_update as $comp) {
                                    $comp->status_id = $this->spStatusConverter($component->status);
                                    $comp->save();
                                }
                            }
                        }

                        /*
                         * |----------------------
                         * | Incidents
                         * |----------------------
                         */
                        /* if($provider->create_linked_incidents){
                            $response_body = json_decode(Http::get('https://'.$provider->domain.'/api/v2/incidents/unresolved.json')->body());
                            $incidents = $response_body->incidents;

                            foreach ($incidents as $incident){
                                //
                            }
                        }*/
                        break;
                }
            }
        }

        DB::table($comp_table)->where('available', false)->delete();
        DB::table($inc_table)->where('available', false)->delete();
        return 0;
    }

    private function resolves($value){
        return checkdnsrr($value, 'A') || checkdnsrr($value, 'AAAA') || checkdnsrr($value, 'CNAME');
    }

    private function spStatusConverter($status){
        switch ($status){
            case 'operational':
                return 2;
            case 'degraded_performance':
                return 3;
            case 'partial_outage':
                return 4;
            case 'major_outage':
                return 5;
            case 'under_maintenance':
                return 6;
        }
    }
}
