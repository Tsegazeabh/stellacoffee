<?php

namespace App\Http\Requests\CMS;

use App\Rules\XSSValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerTestimonialFormRequest extends FormRequest
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
            "testimonial_name" => "required|max:255",
            "testimonial_organization" => "nullable|max:255",
            "testimonial_position" => "nullable|max:255",
            "testimonial_message" => [
                "required",
                new XSSValidator()
            ],
            "testimonial_date" => "nullable|date_format:Y-m-d",
            "video_link" => "nullable"
        ];
    }
}
