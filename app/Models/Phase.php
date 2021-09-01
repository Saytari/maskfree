<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function plan()
    {
        return $this->hasOne(\App\Models\Plan::class);
    }

    public function priorities()
    {
        return $this->hasMany(\App\Models\Priority::class);
    }
}
