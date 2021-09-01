<?php

namespace App\Http\Requests;

class StoreManager extends StoreUser
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
        $managerRules = parent::rules();

        $managerRules['birth_date'] = 'required|date_format:Y-m-d|before:-25 year|after: -60 year';

        $managerRules['center_id'] = 'required|integer|exists:centers,id|unique:managers,center_id';

        return $managerRules;
    }
}
