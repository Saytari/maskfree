<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccine extends FormRequest
{
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'min' => 'يجب أن تكون عدد المحارف :min على الأقل',
            'unique' => 'القيمة المدخلة موجودة مسبقاً.',
            'alpha' => 'يجب أن تتكون من أحرف فقط',
            'numeric' => 'يجب أن تكون القيمة عددية',
            'integer' => 'يجب أن تكون القيمة عدد صحيح'
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
            'name' => 'required|string|unique:vaccines',
            'country' => 'required|alpha',
            'efficiency' => 'required|numeric|between:0,1',
            'period_between_doses' => 'required|integer|min:1',
            'immunization' => 'required|integer|min:1',
            'total_doses' => 'required|integer|min:1'
        ];
    }
}
