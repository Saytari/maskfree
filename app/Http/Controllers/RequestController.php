<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Services\RequestService;
use App\Http\Resources\RequestResource;
use App\Services\SchedulingAppointmentsService;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RequestService $requestServices)
    {
        $requests=$requestServices->all();
        return  RequestResource::collection($requests);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request,RequestService $requestService)
    {

        

        $store = $requestService->create($request->all());
        $sas = new SchedulingAppointmentsService();
        $sas->scheduling();
        return $store;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return new RequestResource($request);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, RequestService $requestService)
    {
       
     //   Request::where('id',7)->delete();

     

     //   $user->delete();

        return $requestService->delete($id);
    }
}
