<?php

namespace App\Http\Requests;

use Faker\Core\Uuid;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * Get the body parameters that are applicable to this request.
     * @return array[]
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'The email of the user',
            ],
            'password' => [
                'description' => 'The password of the user',
            ]
        ];
    }
}
