<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
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
            'name' => 'required|string|max:128',
            'email' => 'required|email|max:255|unique:accounts',
            'password' => 'required|min:6|confirmed',
            'mobile_country_calling_code' => 'required|string|max:15',
            'mobile_phone' => 'required|string|max:30'
        ];
    }
}
