<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedStatusComponent extends Model
{
    use HasFactory;

    public function linkedStatusProvider(){
        return $this->belongsTo(LinkedStatusProvider::class);
    }

    public function getCombinedNames(){
        return $this->name.($this->group_name ? ' ('.$this->group_name.')' : '');
    }

    public static function hasExternalComponent($external_id, $provider_id): bool{
        return self::where('external_id', $external_id)->where('linked_status_provider_id', $provider_id)->exists();
    }
}
