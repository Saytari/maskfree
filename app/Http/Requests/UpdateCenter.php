<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCenter extends FormRequest
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
        $center = $this->route()->center;

        return [
            'name' => 'required|string|min:2|unique:centers,name,' . $center->id,
            'street' => 'required|string',
            'city' => 'required|alpha',
            'phones' => 'required|array',
            'phones.0' => 'required',
            'phones.*' => "digits:10|distinct|unique:center_phones,number,{$center->id},center_id"
        ];
    }
}
