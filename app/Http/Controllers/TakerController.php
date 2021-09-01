<?php

namespace App\Http\Controllers;
use App\Models\Taker;
use App\Models\User;
use App\Services\TakerService;
use App\Services\RequestService;
use App\Services\AppointmentService;

use App\Http\Resources\UserResource;
use App\Http\Requests\StoreTaker;
use App\Http\Requests\UpdateTaker;
use Illuminate\Http\Request;


class TakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( TakerService $takerService)
    {
        $takers = $takerService->all();

        return UserResource::collection($takers);
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaker $request, TakerService $takerService)
    {
        $takerService->create($request->all());

        return $this->successMessage();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Taker $taker )
    {
        return new UserResource($taker->user);
    }
    public function showMyProfile()
    {
        $taker=Auth()->user();
        return new UserResource($taker);
    }
   



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaker $request, Taker $taker,TakerService $takerService)
    {
        $takerService->update($taker, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taker $taker, TakerService $takerService)
    {
        $takerService->delete($taker);

        return $this->successMessage();
    }

    public function hasRequest(User $user,RequestService $requestService){
        return $requestService->userHasRequest($user);
    }
    public function hasAppointment(User $user,AppointmentService $appointementService){
        return $appointementService->userHasAppointment($user);
    }
    public function couldOrder()
    {
        return ['couldOrder'=>'true'];
    }
}
