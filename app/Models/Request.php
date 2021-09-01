<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'center_id',
        'request_date',
        'user_id',

    ];
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function center()
    {
        return $this->hasOne(Center::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
