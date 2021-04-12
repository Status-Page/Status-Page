<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use App\Events\MetricDeleting;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Metric extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'deleting' => MetricDeleting::class,
    ];

    public function points(){
        return $this->hasMany(MetricPoint::class);
    }

    public function expand(){
        return $this->collapse == 'expand_always' ? 'Always' : 'On click';
    }

    public function shouldExpand(): string
    {
        if($this->collapse == 'expand_always')
            return 'true';
        return 'false';
    }

    public function getPointsSinceMinutes($minutes){
        $points = $this->points()
            ->select(['created_at as key', DB::raw('avg(value) as value')])
            ->whereBetween('created_at', [Carbon::now()->setSeconds(0)->subMinutes($minutes), Carbon::now()])
            ->groupBy(DB::raw('HOUR(`created_at`)'), DB::raw('MINUTE(`created_at`)'))
            ->orderBy('created_at')
            ->get();

        return $this->formatForHomePage($points);
    }

    public function getPointsSinceHours($hours){
        $points = $this->points()
            ->select(['created_at as key', DB::raw('avg(value) as value')])
            ->whereBetween('created_at', [Carbon::now()->setSeconds(0)->setMinutes(0)->subHours($hours), Carbon::now()])
            ->groupBy(DB::raw('HOUR(`created_at`)'))
            ->get();

        return $this->formatForHomePage($points);
    }

    public function getPointsSinceDays($days){
        $points = $this->points()
            ->select(['created_at as key', DB::raw('avg(value) as value')])
            ->whereBetween('created_at', [Carbon::now()->setSeconds(0)->setHours(0)->setMinutes(0)->subDays($days), Carbon::now()])
            ->groupBy(DB::raw('DATE(`created_at`)'))
            ->get();

        return $this->formatForHomePage($points);
    }

    private function formatForHomePage($points){
        $return = (object) [
            'labels' => [],
            'points' => [],
        ];

        foreach ($points as $point){
            array_push($return->labels, Carbon::createFromTimeString($point->key)->format('d.m.Y - H:i'));
            array_push($return->points, $point->value);
        }

        return $return;
    }
}
