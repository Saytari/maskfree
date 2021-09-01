<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryStates extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "category_states";
    
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
