<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaker extends StoreUser
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
        $TakerRules=parent::rules();
        $TakerRules['medical_notes']='string';
        $TakerRules['has_medical_job']='required';
        $TakerRules['taker_type']=['required', Rule::in(['t', 'r'])];
        $TakerRules['password']='required|string|min:8';


        return $TakerRules;
    }
}
