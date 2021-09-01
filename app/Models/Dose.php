<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dose extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function centerDoses()
    {
        return $this->hasMany(CenterDose::class);
    }
}
