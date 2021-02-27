<?php

namespace App\Http\Requests\Api\Restaurant;

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:30',
            'email' => 'required|email|unique:restaurants,email',
            'phone' =>'required|digits_between:10,13|unique:restaurants,phone',
            'whatsapp' =>'required|digits_between:10,13|unique:restaurants,whatsapp',
            'password' =>'required|min:6',
            'password_confirmation' =>'required|same:password',
            'min_price' =>'required|numeric|min:1',
            'fees' =>'required|numeric|min:1',
            'path' =>'required|image|mimes:jpg,jpeg,png,gif',
            'city_id' =>'required|exists:cities,id',
            'region_id' =>'required|exists:regions,id',
        ];
    }
}
