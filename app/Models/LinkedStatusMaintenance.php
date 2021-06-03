<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedStatusMaintenance extends Model
{
    use HasFactory;

    public function linkedStatusProvider(){
        return $this->belongsTo(LinkedStatusProvider::class);
    }
}
