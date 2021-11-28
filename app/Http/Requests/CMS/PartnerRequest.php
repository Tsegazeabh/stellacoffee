<?php

namespace App\Http\Requests\CMS;

use App\Rules\ValidFileType;
use App\Rules\ValidImageType;
use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PartnerRequest extends FormRequest
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
                'title' => 'required|string',
                'attachments' => ['required', 'image', 'max:5242880', new ValidImageType()],
                'link' => 'required|url',
                'detail' => [
                    'nullable',
                    new XSSValidator()
                ],
//            'tags' => 'nullable|array',
            ];
    }
}
