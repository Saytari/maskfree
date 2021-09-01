<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       // 'password',
    ];

    protected $with = [
        'role'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function master()
    {
        return $this->hasOne(Master::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    public function vaccinator()
    {
        return $this->hasOne(Vaccinator::class);
    }

    public function receptionist()
    {
        return $this->hasOne(Receptionist::class);
    }
    public function taker()
    {
        return $this->hasOne(Taker::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function centerLine()
    {
        return $this->belongsTo(CenterLine::class);
    }
    public function request(){
        return $this->hasone(Request::class);
    }

}
