<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UptimeRobotMonitor extends Model
{
    use HasFactory;

    protected $attributes = [
        'paused' => true,
        'available' => true,
    ];

    protected $fillable = [
        'monitor_id',
        'friendly_name',
        'status_id',
        'component_id',
        'metric_id',
        'available',
    ];

    public function component(){
        return $this->belongsTo(Component::class);
    }

    public function metric(){
        return $this->belongsTo(Metric::class);
    }

    public function status(){
        switch ($this->status_id){
            case 0:
                return 6;
            case 2:
                return 2;
            case 8:
                return 4;
            case 9:
                return 5;
            default:
                return 1;
        }
    }

    public static function hasURMonitor(int $ur_id): bool {
        return self::where('monitor_id', $ur_id)->exists();
    }
}
