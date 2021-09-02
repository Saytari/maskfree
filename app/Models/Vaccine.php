<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccine extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'efficiency' => 'double'
    ];

    protected $with = [
        'country',
        'doses'
    ];

    protected $guarded = [];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function appointment()
    {
        return $this->belongsTo(appointment::class);
    }


    public function doses()
    {
        return $this->hasMany(Dose::class);
    }

    public function getTotalDosesAttribute()
    {
        return $this->doses->count();
    }

    public function appos()
    {
        return $this->hasMany(Appointment::class);
    }
}
