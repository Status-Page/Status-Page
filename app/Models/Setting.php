<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    public static function getString($key, $default = ""): string
    {
        $query = self::query()->where('key', $key)->get();
        if($query->count() == 1){
            return $query->first()->value;
        }
        return $default;
    }

    public static function getInteger($key, $default = 0): int
    {
        $query = self::query()->where('key', $key)->get();
        if($query->count() == 1){
            return intval($query->first()->value);
        }
        return $default;
    }

    public static function getBoolean($key, $default = false): bool
    {
        $query = self::query()->where('key', $key)->get();
        if ($query->count() == 1) {
            return boolval($query->first()->boolval);
        }
        return $default;
    }
}
