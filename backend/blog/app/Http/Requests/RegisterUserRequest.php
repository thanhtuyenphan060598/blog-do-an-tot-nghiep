<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            //
            'username' => 'required|max:10|string|unique:users|string',
            'email' => 'required|email|unique:users|string',
            'password' => 'required|min:3|max:10|string'
        ];
    }
    public function messages()
    {
       return [
        ];
    }

}
