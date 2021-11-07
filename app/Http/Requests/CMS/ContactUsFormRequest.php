<?php

namespace App\Http\Requests\CMS;

use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsFormRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'=>'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'professional_area' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:255',
            'country_id' => 'required|string',
            'receive_update' => 'required|boolean',
            'detail' => [
                'required',
                new XSSValidator()
            ]
        ];
    }
}
