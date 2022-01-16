<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CityRequest extends FormRequest
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
        $method_name =$this->route()->getActionMethod();
        if($method_name ==='createPost'){
            return [
                'country_id' => 'required|numeric',
                'name' => ['required', 'string', 'max:255', 'unique:cities'],
                'name_am' => 'required|string',
                'name_fr' => 'nullable|string',
                'name_it' => 'nullable|string',
                'description' => 'nullable|string',
                'description_am' => 'nullable|string',
                'description_fr' => 'nullable|string',
                'description_it' => 'nullable|string'
            ];
        }else if($method_name ==='editPost'){
            $city_id=$this->route()->parameters()['id'];
            return [
                'country_id' => 'required|numeric',
                'name' => ['required', 'string', 'max:255', 'unique:cities,name,'.$city_id],
                'name_am' => 'required|string',
                'name_fr' => 'nullable|string',
                'name_it' => 'nullable|string',
                'description' => 'nullable|string',
                'description_am' => 'nullable|string',
                'description_fr' => 'nullable|string',
                'description_it' => 'nullable|string'
            ];
        }else{
            return [
                'country_id' => 'required|numeric',
                'name' => 'required|string|max:255',
                'name_am' => 'required|string',
                'name_fr' => 'nullable|string',
                'name_it' => 'nullable|string',
                'description' => 'nullable|string',
                'description_am' => 'nullable|string',
                'description_fr' => 'nullable|string',
                'description_it' => 'nullable|string'
            ];
        }
    }
}
