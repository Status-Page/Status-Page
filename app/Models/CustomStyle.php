<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomStyle extends Model
{
    use HasFactory;

    public static function getActiveStyles(string $type = null){
        if ($type != null)
            return self::query()->where('active', '=', true)->where($type, '=', true)->get();
        else
            return self::query()->where('active', '=', true)->get();
    }

    public static function hasActiveStyles(string $type = null){
        if ($type != null)
            return self::query()->where('active', '=', true)->where($type, '=', true)->count() > 0;
        else
            return self::query()->where('active', '=', true)->count() > 0;
    }
}
