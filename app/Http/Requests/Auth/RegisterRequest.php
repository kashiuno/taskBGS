<?php

namespace App\Http\Requests\Auth;

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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ];
    }
    /**
     *
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max:255' => 'Name max length is 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'It is a not valid email address',
            'email.unique' => 'User with current email exist',
            'email.max:255' => 'Email max length is 255 characters',
            'password.required' => 'Password is required',
            'password.min:8' => 'Password length must be better then 8 characters',
            'password.confirmed' => 'Password requires confirmation',
        ];
    }
}
