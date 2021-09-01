<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $AppointmentRole['taker_id']='required|exists:takers,taker_id';
        $AppointmentRole['center_name']='required|exists:centers,center_name';
        //$AppointmentRole['request-id']='';
        $AppointmentRole['vaccine_name']='required|exists:vaccines,name';
        $AppointmentRole['dose_number']='required';//less than the number in the diceded vaccine
        $AppointmentRole['appointment_date']='required|date-format:Y-m-d';

        return $AppointmentRole;


    }
}
