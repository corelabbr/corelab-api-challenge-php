<?php

declare(strict_types = 1);

namespace App\Http\Requests\Task;

/**
 * @OA\Schema(
 *     schema="StoreTaskRequest",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Concluir a documentação do projeto"),
 *     @OA\Property(property="description", type="string", example="Escrever documentação abrangente para o projeto"),
 *     @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="pending", description="Status da tarefa"),
 *     @OA\Property(property="color_id", type="integer", example=2, description="ID da cor da tarefa"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2025-12-31", description="Data de vencimento no formato YYYY-MM-DD")
 * )
 */
class StoreTaskRequest extends BaseTaskRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge($this->commonRules(), [
            'title' => 'required|string|min:3|max:255',
        ]);
    }
}
