<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Request;
use DateTime;
use App\Models\Center;
use Carbon\Carbon;
use App\Http\Resources\CenterResource;
//use RequestService;
use Illuminate\Support\Collection;

class AppointmentService
{
    public function all()
    {
        return Appointment::all();
    }

    public function createModel($request, $date)
    {
        $appointment=new Appointment();
        
            $appointment->request_id=$request->id;
            $appointment->user_id=$request->user_id;
            $appointment->center_id=$request->center_id;
            $appointment->vaccinator_id=1;
            $appointment->dose_id=$request->center_id;
            $appointment->vaccine_id=$request->center_id;
            $appointment->image_Signature='null';
            $appointment->appointment_date=$date;
        
       
        $appointment->save();
        return ;
    }

    public function delete($appointment)
    {
        $appointment= Appointment::where('user_id', '=', $appointment->user_id)->first();
        if($appointment){
        $appointment->delete();
        }
    }
    public function AddSignature(Collection $SignatureImage,$appointment)
    {
        $SignatureImage->file->store('product', 'public');
        $appointment->image_Signature= $SignatureImage->file->hashName();
       // $appointment->save();
        return $appointment;

    }
    public function AddVaccinator($appointment)
    {
        $appointment->vaccinator_id=auth()->user()->id;
        $appointment->image_Signature="not null";
        $appointment->update($appointment->only('vaccinator_id'));
        $appointment->update($appointment->only('image_Signature'));
    }
    public function userHasAppointment($user)
    {
        if (Appointment::where('user_id', '=', $user->id)->exists()) {
            $appointment=Appointment::where('user_id', '=', $user->id)->get()->last();
            $center=Center::where('id', '=', $appointment->center_id)->first();
            if ($appointment->image_Signature=="null"){
                return ['appointment'=>$appointment,
                'center'=>new CenterResource($center)    ];
            }
         }
        return ['hasAppointment'=>'user has no appointment'];
    }
    public function userHasCurrentAppointment($user)
    {
        if (Appointment::where('user_id', '=', $user->id)->exists()) {
            $appointment=Appointment::where('user_id', '=', $user->id)->first();
            $center=Center::where('id', '=', $appointment->center_id)->first();
            $now = Carbon::now();
            $now->addHours(3);
            $edate =new Carbon($appointment->appointment_date);
            if ( $now->isSameDay($edate)){
                if (auth()->user()->receptionist->center_id == $appointment->center_id)
                return ['appointment'=>$appointment,
                'center'=>new CenterResource($center)
               ];
            }   
         }
       
        return ['hasAppointment'=>'user has no appointment'];
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



    public function allTakerAppointment()
    {
        $taker=auth()->user()->id;
        if( Appointment::where('taker_id', '=', $taker)->exists())
           return Appointment::where('taker_id', '=', $taker)->all();
        else
        return ['taker'=>'taker has no appointments'];
    }
    public function getAppointmentId($taker)
    {
        if( Appointment::where('taker_id', '=', $taker)->exists())
        {
            $appointment=Appointment::where('taker_id', '=', $taker)->first();
            return $appointment->id;
        }
        else return ['taker'=>'taker has no appointment'];
    }
    public function dateExists($date,$center_id)
    {
        if( Appointment::where('appointment_date', '=', $date)->exists())
        {
            $appointment=Appointment::where('appointment_date', '=', $date)->first();
            if($appointment->center_id==$center_id){
                return true;
            }


        }
        
    }

    }


