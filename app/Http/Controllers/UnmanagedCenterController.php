<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;
use App\Http\Resources\CenterResource;

class UnmanagedCenterController extends Controller
{
    public function index() {
        $unmanaged = Center::doesntHave("manager")->get();

        return CenterResource::collection($unmanaged);
    }
}
