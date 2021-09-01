<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterDose extends Model
{
    use HasFactory;

    public function center()
    {
        return $this->belongsTo(\App\Models\Center::class);
    }

    public function dose()
    {
        return $this->belongsTo(\App\Models\Dose::class);
    }
}
