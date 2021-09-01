<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }

    public function priorties()
    {
        return $this->hasMany(\App\Models\Priority::class);
    }

    public function states()
    {
        return $this->hasOne(\App\Models\CategoryStates::class);
    }
}
