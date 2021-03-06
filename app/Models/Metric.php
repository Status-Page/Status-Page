<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    public function points(){
        return $this->hasMany(MetricPoint::class)->latest();
    }

    public function getPointsLastHours($lastHours): object
    {
        $return = (object) [
            'labels' => [],
            'points' => [],
        ];
        for ($i = $lastHours-1; $i >= 0; $i--){
            array_push($return->labels, Carbon::now()->subHours($i)->setMinutes(0)->format('H:i'));

            $points = $this->points()->whereBetween('created_at', [Carbon::now()->subHours($i)->setMinutes(0), Carbon::now()->subHours($i-1)->setMinutes(0)])->get();
            array_push($return->points, $points->avg('value') ?? 0);
        }

        return $return;
    }
}
