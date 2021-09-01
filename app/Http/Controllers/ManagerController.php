<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Services\ManagerService;
use App\Http\Requests\StoreManager;
use App\Http\Resources\ManagerResource;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManagerService $managerService)
    {
        $managers = $managerService->all();

        return ManagerResource::collection($managers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManager $request, ManagerService $managerService)
    {
        $managerService->create($request->all());

        return $this->successMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(Manager $manager)
    {
        return new ManagerResource($manager);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        Manager $manager,
        ManagerService $managerService
    ) {
        $managerService->update($manager, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager, ManagerService $managerService)
    {
        $managerService->delete($manager);

        return $this->successMessage();
    }

    public function me() {

        return new ManagerResource(auth()->user()->manager);
    }
}
