<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'number'
    ];

    public function center()
    {
        return $this->hasOne(Center::class);
    }
}
