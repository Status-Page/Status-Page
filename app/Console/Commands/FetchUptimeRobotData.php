<?php

namespace App\Console\Commands;

use App\Models\Component;
use App\Models\MetricPoint;
use App\Models\Setting;
use App\Models\UptimeRobotMonitor;
use App\Statuspage\UptimeRobot\UptimeRobot;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Log;

class FetchUptimeRobotData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:fetchuptimerobot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the Uptime Robot Data';

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
        if(Setting::getString('uptimerobot_key') != ''){
            $ur = new UptimeRobot(Setting::getString('uptimerobot_key'));
            $urdata = $ur->getMonitorsData();
            if($urdata['stat'] != 'ok'){
                Log::error('[UPTIMEROBOT_IMPORT] API Call fails:', $urdata['error']);
                return 1;
            }

            $urtable = (new UptimeRobotMonitor())->getTable();
            DB::table($urtable)->update([
                'available' => false
            ]);

            foreach ($urdata['monitors'] as $monitor){
                if(!UptimeRobotMonitor::hasURMonitor($monitor['id'])){
                    $mon = new UptimeRobotMonitor();
                    $mon->monitor_id = $monitor['id'];
                    $mon->friendly_name = $monitor['friendly_name'];
                    $mon->status_id = $this->hasActiveMaintenanceWindow($monitor['mwindows'], $urdata['timezone']) ? 0 : $monitor['status'];
                    $mon->save();
                }else{
                    $mon = UptimeRobotMonitor::query()->where('monitor_id', $monitor['id'])->first();
                    $mon->available = true;
                    $mon->status_id = $this->hasActiveMaintenanceWindow($monitor['mwindows'], $urdata['timezone']) ? 0 : $monitor['status'];
                    $mon->save();

                    if(!$mon->paused && $mon->available){
                        if($mon->component_id){
                            $component = Component::query()->where('id', $mon->component_id)->firstOrFail();
                            if($component->status_id != $mon->status()){
                                $component->status_id = $mon->status();
                                $component->save();
                            }
                        }

                        if($mon->metric_id && !$this->hasActiveMaintenanceWindow($monitor['mwindows'], $urdata['timezone'])){
                            $metric_point = new MetricPoint();
                            $metric_point->metric_id = $mon->metric_id;
                            $metric_point->value = doubleval($monitor['response_times'][0]['value']);
                            $metric_point->save();
                        }
                    }
                }
            }

            DB::table($urtable)->where('available', false)->delete();
        }
        return 0;
    }

    private function hasActiveMaintenanceWindow(array $mwindows, $tz = null): bool
    {
        $hasActive = false;
        for ($i = 0; $i < count($mwindows); $i++){
            $start_time = Carbon::createFromTimestamp($mwindows[$i]['start_time']);
            if(str_starts_with($tz, '+'))
                $start_time->addMinutes(str_replace('+', '', $tz));
            if(str_starts_with($tz, '-'))
                $start_time->subMinutes(str_replace('-', '', $tz));
            $duration = $mwindows[$i]['duration'];
            if($start_time->addMinutes($duration) > Carbon::now() && $mwindows[$i]['status'] == 1)
                $hasActive = true;
        }
        return $hasActive;
    }
}
