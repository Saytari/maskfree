<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function me() 
    {
        $user = auth()->user();
        
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'father_name' => $user->father_name,
            'gender' => $user->gender,
            'birth_date' => $user->birth_date,
            'phone' => $user->phone,
            'identity_number' => $user->identity_number,
        ];
    }
}
