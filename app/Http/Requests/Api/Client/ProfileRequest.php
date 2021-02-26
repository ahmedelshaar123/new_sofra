<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => 'required|min:2|max:30|regex:/^[\pL\s\-]+$/u',
            'email' => Rule::unique('clients', 'email')->ignore($request->user()->id),'required|email',
            'phone' =>Rule::unique('clients', 'phone')->ignore($request->user()->id),'required|digits_between:10,13',
            'password' =>'nullable|min:6',
            'password_confirmation' =>'nullable|same:password',
            'city_id' =>'required|exists:cities,id',
            'region_id' =>'required|exists:regions,id',
            'path' =>'image|mimes:jpg,jpeg,png,gif',
        ];
    }
}
