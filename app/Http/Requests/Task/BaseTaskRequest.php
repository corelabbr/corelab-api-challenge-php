<?php

declare(strict_types = 1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class BaseTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get common validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    protected function commonRules(): array
    {
        return [
            'title'       => 'string|min:3|max:255',
            'description' => 'nullable|string',
            'status'      => 'in:pending,in_progress,completed',
            'due_date'    => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
            'color_id'    => 'nullable|exists:task_colors,id',
        ];
    }
}
