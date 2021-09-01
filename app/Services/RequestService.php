<?php

namespace App\Services;

use App\Models\Request;
use App\Models\Center;
use Illuminate\Support\Collection;
use App\Http\Resources\CenterResource;
class RequestService extends AbstractService
{

    public function all()
    {
        return Request::all();
    }



    public function createModel(Collection $RequestData)
    {
        $request = Request::firstOrCreate([
            'center_id' => $RequestData->get('center_id'),
            'request_date' => $RequestData->get('request_date'),
            'user_id'=>auth()->user()->id
        ]);


        return $request;
    }


    public function update($request, $RequestData)
    {


    }
    public function delete($request)
    {
        return Request::where('id',$request)->first()->delete() ;

    }

    public function userHasRequest($user)
    {
        if (Request::where('user_id', '=', $user->id)->exists()) {
            $request=Request::where('user_id', '=', $user->id)->first();
            $center=Center::where('id', '=', $request->center_id)->first();
            return ['request'=>$request,
            'center'=>new CenterResource($center)    ];
         }
        else
        return ['hasrequest'=>'user has no request'];
    }


}
