<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DayResource;
use App\Models\Center;

class DayController extends Controller
{
    public function index()
    {

        return \App\Models\Day::all();
    }

    public function show(Center $center)
    {
        
        return [
            "days_id" => $center->days->pluck('day_id'),
            "openning_time" => $center->days()->first()->periods()->first()->openning_time,
            "closing_time" => $center->days()->first()->periods()->first()->closeing_time
        ];
    }

    public function store(Request $request, Center $center)
    {
        foreach($center->days as $day)
            foreach($day->periods as $period)
                $period->delete();

        $center->days()->delete();

        foreach (\App\Models\Day::all() as $day) {
            if (collect($request->days_id)->contains($day->id)) {
                $period = $center->days()->create([
                    'day_id' => $day->id
                ]);

                $period->periods()->create([
                    'openning_time' => $request->openning_time,
                    'closeing_time' => $request->closing_time
                ]);
            }
        }

        return $this->successMessage();
    }
}
