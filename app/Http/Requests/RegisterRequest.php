<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ];
    }

    /**
     * Get the body parameters that are applicable to this request.
     * @return array[]
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the user',
            ],
            'email' => [
                'description' => 'The email of the user',
            ],
            'password' => [
                'description' => 'The password of the user',
            ],
            'password_confirmation' => [
                'description' => 'The password confirmation',
            ]
        ];
    }
}
