<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $requestRule['center_id']='required|';//|exists:centers,id';
        $requestRule['request_date']='required';//|date-format:YYYY-MM-DD';
       // $requestRule['prefferd_day']=['required', Rule::in(['sunday', 'monday','tuesday','wednsday','thursday','friday','saturday'])];

        return $requestRule;
    }
}
