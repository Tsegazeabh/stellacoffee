<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CountryRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:255', 'unique:countries'],
                'name_am' => 'required|string',
                'name_fr' => 'nullable|string',
                'name_it' => 'nullable|string',
                'description' => 'nullable|string',
                'description_am' => 'nullable|string',
                'description_fr' => 'nullable|string',
                'description_it' => 'nullable|string'
            ];
        }else if($method_name ==='editPost'){
            $country_id=$this->route()->parameters()['id'];
            return [
                'name' => ['required', 'string', 'max:255', 'unique:countries,name,'.$country_id],
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
