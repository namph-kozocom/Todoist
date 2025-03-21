<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'username.required'=> 'Username is required, please enter your username',
            'username.max'=> 'Username must be less than 255 characters',
            'username.unique'=> 'Username already exists',
            'email.required' => 'Email is required, please enter your email',
            'email.email' => 'Your email is not valid',
            'email.unique'=> 'Email already exists, please enter another email',
            'password.required' => 'Password is required, please enter your password',
            'password.min' => 'Password must be at least 6 characters',
        ];
    }
}
