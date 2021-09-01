<?php

namespace App\Services;

use App\Models\Request;
use DateTime;
use Carbon\Carbon;

class SchedulingAppointmentsService
{
    public function scheduling()
    {

        $appointmentServices = new AppointmentService();
        $allRequest = Request::orderBy('center_id')->get()->groupBy('center_id');

        /*
         $center=Center::where('id', '=', $request[0]->center_id)->first();
          $centerOpiningTime=new CenterService->getCenteropenningTime($center);
          $centerClosingTime=new CenterService->getCenterclosingTime($center);



          */
        foreach ($allRequest as $request) {
            $date = Carbon::today();
            $centerOpiningTime = Carbon::create(0000, 0, 00, 7, 00);
            $centerClosingTime = Carbon::create(0000, 0, 00, 8, 00);
            $date->hour = $centerOpiningTime->hour;
            $date->minute = $centerOpiningTime->minute;
            $dayClosing = Carbon::today();
            $dayClosing->hour = $centerClosingTime->hour;
            $dayClosing->minute = $centerClosingTime->minute;
            for ($i = 0; $i < $request->count(); $i++) {

            for ($d = $date; $d->diffInDays($date) < 6; $d = $d->addDay(1)) {

                $b = false;
                $l=$date->toDateTime();

                for ($h = $date; $h->diffInHours($dayClosing)>=0; $h->addMinute(10)) {
                    if ($h->diffInMinutes($dayClosing) == 0&&!$appointmentServices->dateExists($h, $request[$i]->center_id)) {


                        $h->addDay(1);
                        $h->hour = $centerOpiningTime->hour;
                        $h->minute = $centerOpiningTime->minute;
                        $appointmentServices->createModel($request[$i], $h->toDateTime());
                        $h->subDay();
                        break;
                    }

                    if (!$appointmentServices->dateExists($h, $request[$i]->center_id)) {
                        $appointmentServices->createModel($request[$i], $h->toDateTime());
                        $j = $h;
                        $b = true;
                        $date->addMinute(10);



                        break;

                    }
                }
                if ($b == true) {
                    break;
                }
            }
        }
        }
        Request::truncate();
    }
}
