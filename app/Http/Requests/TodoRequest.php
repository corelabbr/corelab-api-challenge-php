<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'color' => 'nullable',
            'favorite' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório',
            'description.required' => 'A descrição é obrigatória'
        ];
    }
}
