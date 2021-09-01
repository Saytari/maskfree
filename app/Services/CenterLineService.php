<?php

namespace App\Services;


use Illuminate\Support\Collection;
use App\Models\Center_line;
use App\Models\Receptionist;
use App\Models\User;
use App\Http\Resources\UserResource;
class CenterLineService
{


    public function all()
    {
        return Center_line::all();
    }

    public function createModel( $taker)
    {

        $centerLine = Center_line::Create([
            'user_id'=>$taker->id,
            'center_id'=>auth()->user()->receptionist->center_id
        ]);

        return $centerLine;
    }

    /**
     * @param App\Models\Center
     * @param Array
     */


    public function delete($taker)
    {
        $centerLine= Center_line::where('user_id', '=', $taker)->first();
        if($centerLine){
        $centerLine->delete();
        }
    }
    public function userinLine($user)
    {
      //  return ["s" => $user->id];
        $data = Center_Line::where('user_id', '=', $user->id)
        ->where('center_id', '=', auth()->user()->vaccinator->center_id)->first();

        if ($data != null)
        return new UserResource(User::where('id', '=', $data->user_id)->first());
        else
        return ['hasrequest'=>'user has no request'];
    }

}
