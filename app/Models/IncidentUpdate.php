<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use App\Events\Incidents\IncidentUpdateCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentUpdate extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => IncidentUpdateCreated::class,
    ];

    protected $fillable = [
        'incident_id'
    ];

    public function incident(){
        return $this->belongsTo(Incident::class, 'incident_id')->first();
    }

    public function getType(){
        switch ($this->type){
            case 0:
                return 'Text Update';
            case 1:
                return 'Status Update';
        }
        return '';
    }

    public function getStatus(){
        switch ($this->incident()->type){
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
                return '';
            case 1:
                switch ($this->status){
                    case 0:
                        return 'Planned';
                    case 1:
                        return 'In Progress';
                    case 2:
                        return 'Verifying';
                    case 3:
                        return 'Completed';
                }
                return '';
        }
        return '';
    }

    public function getUpdateType(){
        switch ($this->incident()->type){
            case 0:
                switch ($this->type){
                    case 0:
                        return 'Update';
                    case 1:
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
                }
                return '';
            case 1:
                switch ($this->type){
                    case 0:
                        return 'Update';
                    case 1:
                        switch ($this->status){
                            case 0:
                                return 'Planned';
                            case 1:
                                return 'In Progress';
                            case 2:
                                return 'Verifying';
                            case 3:
                                return 'Completed';
                        }
                }
                return '';
        }
        return '';
    }

    public function getReporter(){
        return $this->belongsTo(User::class, 'user')->first();
    }
}
