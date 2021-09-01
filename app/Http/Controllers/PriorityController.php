<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function show()
    {
        $categories = \App\Models\Plan::latest('created_at')->first()->categories;

        return \App\Http\Resources\PriorityResource::collection($categories);
        
    }
}
