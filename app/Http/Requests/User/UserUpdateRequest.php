<?php
namespace App\Http\Requests\User;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:60',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $this->user()->id,
            'current_password' => 'required_with:new_password|string|min:6',
            'new_password' => 'required_with:current_password|string|min:6|confirmed',
            'telephone' => 'sometimes|string|max:20',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('password')) {
                $validator->errors()->add('password', 'O campo password não é permitido.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.sometimes'     => 'O campo nome é opcional, mas se fornecido deve ser válido.',
            'name.string'        => 'O campo nome deve ser uma string.',
            'name.max'           => 'O nome não pode ter mais que 60 caracteres.',

            'email.sometimes'    => 'O campo email é opcional, mas se fornecido deve ser válido.',
            'email.string'       => 'O campo email deve ser uma string.',
            'email.email'        => 'O campo email deve ser um email válido, exemplo: myaccount@gmail.com.',
            'email.max'          => 'O email não pode ter mais que 255 caracteres.',
            'email.unique'       => 'O email fornecido já está em uso.',

            'current_password.required_with' => 'A senha atual é obrigatória quando uma nova senha é fornecida.',
            'current_password.string'        => 'O campo senha atual deve ser uma string.',
            'current_password.min'           => 'A senha atual deve ter no mínimo 6 caracteres.',

            'new_password.required_with' => 'A nova senha é obrigatória quando uma a senha atual é fornecida.',
            'new_password.string'    => 'O campo nova senha deve ser uma string.',
            'new_password.min'       => 'A nova senha deve ter no mínimo 6 caracteres.',
            'new_password.confirmed' => 'A confirmação da nova senha não corresponde.',

            'telephone.sometimes' => 'O campo telefone é opcional, mas se fornecido deve ser válido.',
            'telephone.string'    => 'O campo telefone deve ser uma string.',
            'telephone.max'       => 'O telefone não pode ter mais que 20 caracteres.',
        ];
    }
}
