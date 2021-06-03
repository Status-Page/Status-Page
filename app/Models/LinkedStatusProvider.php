<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedStatusProvider extends Model
{
    use HasFactory;

    public function incidents(){
        return $this->hasMany(Incident::class);
    }

    public function components(){
        return $this->hasMany(Component::class);
    }

    public function linkedStatusComponents(){
        return $this->hasMany(LinkedStatusComponent::class);
    }
}
