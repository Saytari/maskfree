<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'vaccinator_id',
        'center_id',
        'dose_id',
        'vaccine_id',
        'request_id',
        'appointment_date',
        'image_Signature'
    ];
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'user_id';
    }
    public function center()
    {
        return $this->hasOne(Center::class);
    }
    public function request()
    {
        return $this->hasOne(Request::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function vaccinator()
    {
        return $this->hasOne(Vaccinator::class);
    }
    public function vaccine()
    {
        return $this->hasOne(Vaccine::class);
    }


    public function dose()
    {
        return $this->hasOne(Dose::class);
    }


}
