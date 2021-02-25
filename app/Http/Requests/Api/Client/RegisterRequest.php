<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:30|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:clients,email',
            'phone' =>'required|digits_between:10,13|unique:clients,phone',
            'password' =>'required|min:6',
            'password_confirmation' =>'required|same:password',
            'city_id' =>'required|exists:cities,id',
            'region_id' =>'required|exists:regions,id',
        ];
    }
}
