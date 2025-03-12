<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        $method = $this->method();

        if($method == "PUT") {
            return [
                "title" => ["required", "string", "max:255"],
                "description" => ["required", "string"],
                "favorite" => ["required", "boolean"],
                "color" => ["required", "string", "regex:/^#[0-9A-Fa-f]{6}$/"]
            ];
        } else {
            return [
                "title" => ["sometimes", "string", "max:255"],
                "description" => ["sometimes", "string"],
                "favorite" => ["sometimes", "boolean"],
                "color" => ["sometimes", "string", "regex:/^#[0-9A-Fa-f]{6}$/"]
            ];
        }
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'O título é obrigatório.',
            'title.string'         => 'O título deve ser um texto.',

            'description.required' => 'A descrição é obrigatória.',
            'description.string'   => 'A descrição deve ser um texto.',

            'favorite.required'    => 'O campo favorito é obrigatório.',
            'favorite.boolean'     => 'O campo favorito deve ser verdadeiro ou falso.',

            'color.required'       => 'A cor é obrigatória.',
            'color.string'         => 'A cor deve ser um texto.',
            'color.regex'          => 'A cor deve estar no formato hexadecimal, por exemplo: #FFFFFF.'
        ];
    }
}
