<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taker extends Model
{
    use HasFactory;
    protected $fillable = [
        'has_medical_job',
        'medical_notes',
        'taker_type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
