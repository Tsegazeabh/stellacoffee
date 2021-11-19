<?php

namespace App\Http\Requests\CMS;

use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FactoryLocationFormRequest extends FormRequest
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
            "country_id" => "required|exists:countries,id",
            "city_id" => "required|exists:cities,id",
            "title" => "required|max:255",
            "factory_address" => "required|max:1000",
            "detail" => [
                "required",
                new XSSValidator()
            ],
            "longitude" => "nullable|numeric|max:180|min:-180",
            "latitude" => "nullable|numeric|max:90|min:-90",
            "video_link" => "nullable"
        ];
    }
}
