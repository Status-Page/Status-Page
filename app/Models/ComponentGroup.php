<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentGroup extends Model
{
    use HasFactory;

    public function getComponents(){
        return Component::query()->where([['group', '=', $this->id], ['visibility', '=', true]])->orderBy('order')->get();
    }

    public function getDashComponents(){
        return Component::query()->where([['group', '=', $this->id]])->orderBy('order')->get();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user')->first();
    }

    public function components(){
        return $this->hasMany(Component::class, 'group')->orderBy('order')->get();
    }

    public static function getGroups(){
        return self::query()->where([['visibility', '=', true]])->orderBy('order')->get();
    }

    public static function getAllGroups(){
        return self::query()->orderBy('order')->get();
    }
}
