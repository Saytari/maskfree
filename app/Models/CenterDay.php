<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterDay extends Model
{
    use HasFactory;

    protected $table = "center_days";

    protected $guarded = [];
    
    public function periods()
    {
        return $this->hasMany(\App\Models\CenterDayPeriod::class);
    }

    public function day()
    {
        return $this->belongsTo(\App\Models\Day::class);
    }
}
