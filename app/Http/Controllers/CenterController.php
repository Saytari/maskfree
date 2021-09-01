<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Services\CenterService;
use App\Http\Requests\StoreCenter;
use App\Http\Requests\UpdateCenter;
use App\Http\Resources\CenterResource;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CenterService $centerService)
    {
        
        $centers = $centerService->all();

        return CenterResource::collection($centers);
       //return $centers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCenter $request, CenterService $centerService)
    {
        $centerService->create($request->all());

        return $this->successMessage();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function show(Center $center)
    {
        return new CenterResource($center);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Center  $center
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateCenter $request,
        Center $center,
        CenterService $centerService
    ) {
        $center = $centerService->update($center, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function destroy(Center $center, CenterService $centerService)
    {
        $centerService->delete($center);

        return $this->successMessage();
    }
}
