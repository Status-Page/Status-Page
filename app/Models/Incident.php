<?php

namespace App\Models;

use App\Events\ActionLog;
use App\Mail\ScheduledIncidentStarted;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Incident extends Model
{
    use HasFactory;

    public static function checkMaintenances(){
        $dueMaintenances = Incident::query()
            ->where('type', '=', 1)
            ->where('status', '=', 0)
            ->where('scheduled_at', '<=', Carbon::now())
            ->get();

        if($dueMaintenances->count() > 0){
            foreach ($dueMaintenances as $maintenance){
                $update = new IncidentUpdate();

                $update->incident_id = $maintenance->id;
                $update->type = 1;
                $update->text = 'The maintenance has been started.';
                $update->status = 1;
                $update->user = $maintenance->user;

                $update->save();

                ActionLog::dispatch(array(
                    'user' => 1,
                    'type' => 2,
                    'message' => 'Maintenance '.$maintenance->title.' (ID: '.$maintenance->id.')',
                ));

                //$updates = $maintenance->incidentUpdates()->get();
                // Mail::to(User::query()->where('id', '=', $maintenance->user)->get())->send(new ScheduledIncidentStarted($maintenance, $updates));
            }
        }

        Incident::query()
            ->where('type', '=', 1)
            ->where('status', '=', 0)
            ->where('scheduled_at', '<=', Carbon::now())
            ->update([
                'status' => 1,
                'impact' => 4
            ]);
    }

    public function getImpactColor(){
        switch ($this->impact){
            case 0:
                return 'black';
            case 1:
                return 'yellow-400';
            case 2:
                return 'yellow-600';
            case 3:
                return 'red-500';
            case 4:
                return 'blue-500';
        }
    }

    public function getType(){
        switch ($this->type){
            // Incident
            case 0:
                switch ($this->status){
                    case 0:
                        return 'Investigating';
                    case 1:
                        return 'Identified';
                    case 2:
                        return 'Monitoring';
                    case 3:
                        return 'Resolved';
                }
                break;
            // Maintenance
            case 1:
                switch ($this->status){
                    case 0:
                        return 'Scheduled';
                    case 1:
                        return 'In Progress';
                    case 2:
                        return 'Verifying';
                    case 3:
                        return 'Completed';
                }
                break;
        }
    }

    public function incidentUpdates(){
        return $this->hasMany(IncidentUpdate::class);
    }

    public function getReporter(){
        return $this->belongsTo(User::class, 'user')->first();
    }

    public static function getIncidents(){
        return Incident::query()->where([['status', '!=', 3], ['type', '=', 0]])->get();
    }

    public static function getPastIncidents(){
        return Incident::query()->where([['status', '=', 3], ['type', '=', 0]])->get();
    }

    public static function getMaintenances(){
        return Incident::query()->where([['status', '!=', 3], ['type', '=', 1]])->get();
    }

    public static function getPastMaintenances(){
        return Incident::query()->where([['status', '=', 3], ['type', '=', 1]])->get();
    }

    public static function getUpcomingMaintenances(){
        return Incident::query()->where([['status', '=', 0], ['type', '=', 1]])->get();
    }

    public static function getPublicUpcomingMaintenances(){
        return Incident::query()->where([['status', '=', 0], ['type', '=', 1], ['visibility', '=', true]])->get();
    }

}
