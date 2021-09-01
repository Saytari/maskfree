<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center_line extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'center_id'


    ];
    public function center()
    {
        return $this->hasOne(Center::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }

}
