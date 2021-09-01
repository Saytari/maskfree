<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policy\VaccinatorPolicy;
use App\Services\VaccinatorService;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreVaccinator;
use App\Http\Requests\UpdateVaccinator;
use Illuminate\Http\Request;

class VaccinatorController extends Controller
{
    public function __construct()
    {
       $this->authorizeResource(Vaccinator::class, 'vaccinator');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VaccinatorService $vaccinatorService)
    {
        $vaccinators = $vaccinatorService->all();

        return UserResource::collection($vaccinators);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVaccinator $request, VaccinatorService $vaccinatorService)
    {
       $vaccinatorService->create($request->all());

        return $this->successMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccinator $vaccinator)
    {
        return new UserResource($vaccinator->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateVaccinator $request,
        User $user,
        VaccinatorService $vaccinatorService
    ) {
       $vaccinatorService->update($user->vaccinator, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccinator $vaccinator, VaccinatorService $vaccinatorService)
    {
        $vaccinatorService->delete($vaccinator);

        return $this->successMessage();
    }
}
