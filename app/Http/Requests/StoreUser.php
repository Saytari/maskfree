<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
        return [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'father_name' => 'required|string|min:2',
            'gender' => ['required', Rule::in(['male', 'female'])],
            'phone' => 'required|digits:10|unique:users|unique:center_phones,number',
            'identity_number' => 'required|digits:13|unique:users',
            'birth_date' => 'required|date-format:Y-m-d|before: -20 year',
        ];
    }
}
