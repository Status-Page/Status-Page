<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'long_description'
    ];

    public static function getByOrder($order){
        return self::query()->where('order', '=', $order)->get();
    }

    public function getDefaultName(){
        return ['Unknown', 'Operational', 'Degraded Performance', 'Partial Outage', 'Major Outage', 'Maintenance'][$this->order];
    }

    public function getDefaultLongDescription(){
        return ['', 'All Systems Operational', 'Some services have performance issues', 'There is a partial system outage', 'There is a major system outage', 'We are doing maintenance work...'][$this->order];
    }

    public static function getDefaultNameStatic($order){
        return ['Unknown', 'Operational', 'Degraded Performance', 'Partial Outage', 'Major Outage', 'Maintenance'][$order];
    }

    public static function getDefaultLongDescriptionStatic($order){
        return ['', 'All Systems Operational', 'Some services have performance issues', 'There is a partial system outage', 'There is a major system outage', 'We are doing maintenance work...'][$order];
    }
}
