<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Status extends Model
{
    use HasFactory;

    public static function getByOrder($order){
        return self::query()->where('order', '=', $order)->get();
    }
}
