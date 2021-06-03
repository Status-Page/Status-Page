<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use App\Events\ActionLog;
use App\Mail\Incidents\Scheduled\ScheduledIncidentEnded;
use App\Mail\Incidents\Scheduled\ScheduledIncidentStarted;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Incident extends Model
{
    use HasFactory;

    public static function checkMaintenances(){
        /**
         * @var $dueMaintenances Incident[]
         */
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
                $update->user = 1;

                $update->save();

                foreach ($maintenance->components()->get() as $component){
                    $component->update([
                        'status_id' => 6,
                    ]);
                }

                ActionLog::dispatch(array(
                    'user' => 1,
                    'type' => 2,
                    'message' => 'Maintenance '.$maintenance->title.' (ID: '.$maintenance->id.')',
                ));

                $updates = $maintenance->incidentUpdates()->get();
                Mail::to(User::query()->where('id', '=', $maintenance->user)->get())->queue(new ScheduledIncidentStarted($maintenance, $updates));
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

        /**
         * @var $endedMaintenances Incident[]
         */
        $endedMaintenances = Incident::query()
            ->where('type', '=', 1)
            ->where('status', '!=', 0)
            ->where('status', '!=', 3)
            ->where('end_at', '!=', null)
            ->where('end_at', '<=', Carbon::now())
            ->get();

        if($endedMaintenances->count() > 0){
            foreach ($endedMaintenances as $maintenance){
                $update = new IncidentUpdate();

                $update->incident_id = $maintenance->id;
                $update->type = 1;
                $update->text = 'The maintenance is completed.';
                $update->status = 3;
                $update->user = 1;

                $update->save();

                foreach ($maintenance->components()->get() as $component){
                    $component->update([
                        'status_id' => 2,
                    ]);
                }

                ActionLog::dispatch(array(
                    'user' => 1,
                    'type' => 2,
                    'message' => 'Maintenance '.$maintenance->title.' (ID: '.$maintenance->id.')',
                ));

                $updates = $maintenance->incidentUpdates()->get();
                Mail::to(User::query()->where('id', '=', $maintenance->user)->get())->queue(new ScheduledIncidentEnded($maintenance, $updates));
            }
        }

        Incident::query()
            ->where('type', '=', 1)
            ->where('status', '!=', 0)
            ->where('status', '!=', 3)
            ->where('end_at', '!=', null)
            ->where('end_at', '<=', Carbon::now())
            ->update([
                'status' => 3,
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

    public function components(){
        return $this->belongsToMany(Component::class, 'incident_component');
    }

    public function linkedStatusProviders(){
        return $this->belongsTo(LinkedStatusProvider::class)->withDefault();
    }

}
