<?php

namespace App\Http\Controllers;

use App\Models\Receptionist;
use App\Models\Taker;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Services\ReceptionistService;
use App\Http\Requests\StoreReceptionist;
use App\Http\Requests\UpdateReceptionist;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use App\Services\NotiService;

class ReceptionistController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Receptionist::class, 'receptionist');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReceptionistService $receptionistService)
    {
        $receps = $receptionistService->all();

        return UserResource::collection($receps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceptionist $request, ReceptionistService $receptionistService)
    {
        $receptionistService->create($request->all());

        return $this->successMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receptionist  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function show(Receptionist $receptionist)
    {
        return new UserResource($receptionist->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receptionist  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        Receptionist $receptionist,
        ReceptionistService $receptionistService
    ) {
        $receptionistService->update($receptionist, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receptionist  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receptionist $receptionist, ReceptionistService $receptionistService)
    {
        $receptionistService->delete($receptionist);

        return $this->successMessage();
    }
    public function showTakerProfile(User $user,ReceptionistService $receptionistService)
    {
       return $receptionistService->showTakerProfile($user);
    }
    public function verifiedTakerData(Request $request,User $user,ReceptionistService $receptionistService)
    {
       
         return $receptionistService->addToCenterLine($user,$request->token);
       // return $this->successMessage();
    }
}
