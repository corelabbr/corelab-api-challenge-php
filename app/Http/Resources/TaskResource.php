<?php

declare(strict_types = 1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'status'       => $this->status,
            'status_label' => $this->getStatusLabel(),
            'color'        => [
                'id'       => $this->color_id,
                'name'     => $this->color?->name,
                'hex_code' => $this->color?->hex_code,
            ],
            'due_date'        => $this->due_date?->format('Y-m-d'),
            'is_overdue'      => $this->isOverdue(),
            'is_favorited'    => $this->is_favorited,
            'favorites_count' => $this->favorites->count(),
            'created_at'      => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'      => $this->updated_at->format('Y-m-d H:i:s'),
            'user'            => [
                'id'      => $this->user->id,
                'name'    => $this->user->name,
                'profile' => [
                    'id'          => $this->user->profile->id,
                    'description' => $this->user->profile->description,
                ],
            ],
        ];
    }

    /**
     * transforma o status da tarefa em uma string legível
     *
     * @return string
     */
    private function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending'     => 'Pendente',
            'in_progress' => 'Em Andamento',
            'completed'   => 'Finalizado',
            default       => ucfirst($this->status),
        };
    }

    /**
     * Determinar se a tarefa está vencida
     *
     * @return bool
     */
    private function isOverdue(): bool
    {
        if (! $this->due_date) {
            return false;
        }

        return $this->due_date->isPast() && $this->status !== 'completed';
    }
}
