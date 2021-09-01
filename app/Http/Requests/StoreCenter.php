<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCenter extends FormRequest
{
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن تكون عدد المحارف :min على الأقل',
            'unique' => 'القيمة المدخلة موجودة مسبقاً.',
            'alpha' => 'يجب أن تتكون من أحرف فقط',
            'digits' => 'يجب ان تكون عدد المحارف :digits'
        ];
    }

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
            'name' => 'bail|required|string|min:2|unique:centers',
            'street' => 'bail|required|string',
            'city' => 'bail|required|alpha',
            'phones' => 'required|array',
            'phones.0' => 'required',
            'phones.*' => 'digits:10|unique:center_phones,number',
        ];
    }
}
