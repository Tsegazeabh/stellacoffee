<?php

namespace App\Http\Requests\CMS;

use App\Rules\ValidFileType;
use App\Rules\ValidImageType;
use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CertificationRequest extends FormRequest
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
            'detail' => [
                'required',
                new XSSValidator()
            ],
            'provider' => 'required|max:255',
            "provided_date" => "nullable|date_format:Y-m-d",
            'attachment' => ['required', 'image', 'max:5242880', new ValidImageType()],
//            'tags' => 'nullable|array',
        ];
    }
}
