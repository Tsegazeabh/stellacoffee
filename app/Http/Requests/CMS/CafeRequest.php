<?php

namespace App\Http\Requests\CMS;

use App\Rules\ValidImageType;
use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CafeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'price'=>'nullable|string',
            'size'=>'nullable|string',
            'attachments' => ['required', 'image', 'max:5242880', new ValidImageType()],
            'detail' => [
                'required',
                new XSSValidator()
            ],
            'video_link' => 'nullable|url',
//            'tags' => 'nullable|array',
        ];
    }
}
