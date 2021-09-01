<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerCenterController extends Controller
{
    public function show()
    {
        $center = auth()->user()->manager->center;

        return [
            'name' => $center->name,
            'city' => $center->city->name,
            'street' => $center->street,
            'phones' => [
                $center->phones[0]->number
            ]
        ];
    }
}
