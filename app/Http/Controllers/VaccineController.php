<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Services\VaccineService;
use App\Http\Requests\StoreVaccine;
use App\Http\Requests\UpdateVaccine;
use App\Http\Resources\VaccineResource;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VaccineService $vaccineService)
    {
        $vaccines = $vaccineService->all();

        return VaccineResource::collection($vaccines);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVaccine $request, VaccineService $vaccineService)
    {
        $vaccineService->create($request->all());
        
        return $this->successMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccine $vaccine)
    {
        return new VaccineResource($vaccine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateVaccine $request,
        Vaccine $vaccine,
        VaccineService $vaccineService
    ) {
       $vaccineService->update($vaccine, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccine $vaccine, VaccineService $vaccineService)
    {
        $vaccineService->delete($vaccine);

        return $this->successMessage();
    }
}
