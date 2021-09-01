<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(\App\Models\Category::class);
    }

    public function phases()
    {
        return $this->hasMany(\App\Models\Phase::class);
    }
}
