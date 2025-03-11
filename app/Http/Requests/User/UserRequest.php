<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'       => 'required|max:60',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'telephone'  => 'required|int|min:11',
            'birth_date' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'O campo nome é obrigatório.',
            'name.max'            => 'O nome não pode ter mais que 60 caracteres.',
            'email.required'      => 'O campo email é obrigatório.',
            'email.email'         => 'O campo email deve ser um email válido, exemplo: myaccount@gmail.com.',
            'email.unique'        => 'O email fornecido já está em uso.',
            'password.required'   => 'O campo senha é obrigatório.',
            'password.min'        => 'A senha deve ter no mínimo 6 caracteres.',
            'telephone.required'  => 'O campo telefone é obrigatório.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
        ];
    }
}
