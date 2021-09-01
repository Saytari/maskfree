<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;
use App\Http\Resources\CenterDoseResource;

class CenterDoseController extends Controller
{
    public function show(Center $center)
    {
        return CenterDoseResource::collection($center->centerDoses);
    }

    public function store(Request $request)
    {
        $center = Center::find($request->center_id);

        foreach ($request->body as $dose) {
            $doseInfo = $center->centerDoses()->where('dose_id', $dose['dose_id'])->first();

            $doseInfo->daily_total = $dose['total'];

            $doseInfo->save();
        }

        return $this->successMessage();
    }
}
