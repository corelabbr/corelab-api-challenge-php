<?php

namespace App\Http\Requests\V1\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string"],
            "favorite" => ["boolean"],
            "color" => ["string", "regex:/^#[0-9A-Fa-f]{6}$/"]
        ];
    }

    public function messages()
    {
        return [
            "title" => "Um título é obrigatiório!",
            "description" => "Um descrição é obrigatiória!",
            'color.regex' => 'A cor deve estar no formato hexadecimal, por exemplo: #FFFFFF.'
        ];
    }
}
