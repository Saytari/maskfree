<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'street',
        'city_id'
    ];

    protected $with = [
        'phones',
        'city'
    ];

    // public function setNameAttribute($name)
    // {
    //     $this->attributes['name'];
    // }

    public function phones()
    {
        return $this->hasMany(CenterPhone::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    public function vaccinators()
    {
        return $this->hasMany(Vaccinator::class);
    }

    public function receptionists()
    {
        return $this->hasMany(Receptionist::class);
    }
}
