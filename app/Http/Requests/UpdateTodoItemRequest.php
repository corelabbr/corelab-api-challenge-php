<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255', 'min:3'],
            'description' => ['string', 'min:3'],
            'completed' => ['boolean'],
            'color' => ['hex_color'],
            'due_date' => ['date', 'nullable'],
            'favorite' => ['boolean'],
        ];
    }

    /**
     * Get the body parameters that are applicable to this request.
     * @return array[]
     */
    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'The title of the todo item',
            ],
            'description' => [
                'description' => 'The description of the todo item',
            ],
            'completed' => [
                'description' => 'The completion status of the todo item',
            ],
            'color' => [
                'description' => 'The color of the todo item',
            ],
            'due_date' => [
                'description' => 'The due date of the todo item',
            ],
            'favorite' => [
                'description' => 'The favorite status of the todo item',
            ],
        ];
    }
}
