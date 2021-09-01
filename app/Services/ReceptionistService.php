<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use App\Models\Receptionist;
use Illuminate\Support\Collection;
use App\Http\Resources\UserResource;
use App\Services\CenterLineService;
use App\Services\NotiService;

class ReceptionistService extends AbstractService
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
       $IDs = auth()->user()->manager->center->receptionists->pluck('user.id');
        return User::whereIn('id', $IDs)->get();
    }

    public function createModel(Collection $receptionistData)
    {
        $user = $this->userService->create(
            $receptionistData
            ->except('center_id')
            ->put('role', 'receptionist')
            ->all()
        );

        $user->receptionist()->create([
            'center_id' => auth()->user()->manager->center_id
        ]);

        return $user;
    }

    public function update($receptionist, $updatedData)
    {
        $receptionist->user->update(
            collect($updatedData)
            ->all()
        );
    }

    public function delete($receptionist)
    {
        $receptionist->delete();
    }

    public function showTakerProfile($taker )
    {
       
        $appointmentService=new AppointmentService();
        
        $appointmentstate=$appointmentService->userHasCurrentAppointment($taker);
       
      if( $appointmentstate==['hasAppointment'=>'user has no appointment'])
      {
         return ['taker not valid'=>'has no appointement'];
      }
      else
      {
        return new UserResource($taker);
      }
    }
    public function addToCenterLine($taker,$token)
    {
    //    $NotiService =    new NotiService();
     
        $centerLineService=new CenterLineService();
        $this->sendNoti($taker->noti_token,'done');
        return $centerLineService->createModel($taker);
     
    }
    public function sendNoti ($token,$body){
        // return ["s"=>"s"];
         $SERVER_API_KEY = 'AAAAPalyxCE:APA91bGO_fOPoj8EJGIpDjCk-VF2ww3YkLqhbaThOCgjh1JOkDetmTyIwToABUZ9qrcDMjjvMQZ2lTmXWCDhpINvC_U_RX-9qj5nM4lQ420ZNdxjRx4SqgZ_ojaBc9cCx2cHlrkPrJKs';
 
       //  $token_1 = 
         //'dmZ2RYEVRXirf7MdAfrU1m:APA91bH4rTYapJELb_OCLFn8tTj97-ExvwG4nPcvkflOYJlgz9RQSYIj0RHdTsoZbdaojNu3E5Jo1yPRmy3r5Dye8bTJck0vF9c75GX3ca8oh4mT9krja9t51oz96c-HWhy4TJkVtP1h';
     
         $data = [
     
             "registration_ids" => [
                 $token
             ],
     
             "notification" => [
     
                 "title" => 'Welcome',
     
                 "body" => $body,
     
                 "sound"=> "default" // required for sound on ios
     
             ],
     
         ];
     
         $dataString = json_encode($data);
     
         $headers = [
     
             'Authorization: key=' . $SERVER_API_KEY,
     
             'Content-Type: application/json',
     
         ];
     
         $ch = curl_init();
     
         curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
     
         curl_setopt($ch, CURLOPT_POST, true);
     
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
     
         $response = curl_exec($ch);
      //   dd($response);
        
      }
}
