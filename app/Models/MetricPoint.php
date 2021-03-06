<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'value'
    ];

    public function metric(){
        $this->belongsTo(Metric::class);
    }
}
