<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use App\Models\Vaccinator;
use Illuminate\Support\Collection;
use App\Services\TakerService;
use App\Services\CenterLineService;
use App\Http\Resources\UserResource;


class NotiService extends AbstractService
{
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
         dd($response);
        
      }

}
