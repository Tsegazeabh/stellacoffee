<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegionRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:255', 'unique:regions'],
                'name_lan' => 'required|string',
                'country_id' => 'required|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string',
            ];
        }else if($method_name ==='editPost'){
            $region_id=$this->route()->parameters()['id'];
            return [
                'name' => ['required', 'string', 'max:255', 'unique:regions,name,'.$region_id],
                'name_lan' => 'required|string',
                'country_id' => 'required|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string',
            ];
        }else{
            return [
                'name' => 'required|string|max:255',
                'name_lan' => 'required|string',
                'country_id' => 'required|numeric',
                'description' => 'nullable|string',
                'description_lan' => 'nullable|string',
            ];
        }
    }
}
