<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
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
           'title' => 'required|string|max:255',
           'content' => 'required|string',
           'is_favorite' => 'boolean',
           'color' => 'string|nullable',
        ];
    }
    public function messages()
    {
        return [
           'title.required' => 'O título é obrigatório.',
           'title.string' => 'O título deve ser um texto.',
           'title.max' => 'O título não pode ter mais que 255 caracteres.',
           'content.required' => 'O conteúdo é obrigatório.',
           'content.string' => 'O conteúdo deve ser um texto.',
           'is_favorite.boolean' => 'O valor de favorito deve ser verdadeiro ou falso.',
           'color.string' => 'A cor deve ser um texto.',
        ];
    }
}
