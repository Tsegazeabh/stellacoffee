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
                'name' => ['required', 'string', 'max:255', 'unique:cities'],
                'name_lan' => 'required|string|max:255',
                'region_id' => 'required|numeric',
                'zone_id' => 'nullable|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string'
            ];
        }else if($method_name ==='editPost'){
            $city_id=$this->route()->parameters()['id'];
            return [
                'name' => ['required', 'string', 'max:255', 'unique:cities,name,'.$city_id],
                'name_lan' => 'required|string|max:255',
                'region_id' => 'required|numeric',
                'zone_id' => 'nullable|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string'
            ];
        }else{
            return [
                'name' => 'required|string|max:255',
                'name_lan' => 'required|string|max:255',
                'region_id' => 'required|numeric',
                'zone_id' => 'nullable|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string'
            ];
        }
    }
}
