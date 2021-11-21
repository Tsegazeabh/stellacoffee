<?php

namespace App\Http\Requests\CMS;

use App\Rules\ValidFileType;
use App\Rules\ValidImageType;
use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MainSliderRequest extends FormRequest
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
                'attachments' => ['required', 'image', 'max:5242880', new ValidImageType()],
                'detail' => [
                    'nullable',
                    new XSSValidator()
                ],
            ];
    }
}
