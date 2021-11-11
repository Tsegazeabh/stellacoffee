<?php

namespace App\Http\Requests\CMS;

use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'price'=>'nullable|string',
            'size'=>'nullable|string',
            'detail' => [
                'required',
                new XSSValidator()
            ],
//            'tags' => 'nullable|array',
        ];
    }
}
