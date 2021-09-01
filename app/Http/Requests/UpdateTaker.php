<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaker extends FormRequest
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
        $TakerRules=parent::rules();
        $TakerRules['medical_notes']='';
        $TakerRules['has_medical_job']='required';
        $TakerRules['taker_type']='required';
        return $TakerRules;
    }
}
