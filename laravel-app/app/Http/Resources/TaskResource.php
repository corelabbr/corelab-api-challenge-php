<?php

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
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'status' => $this->status,
            'user' => new UserResource($this->user),
            'categoria' => CategoriaResource::make($this->categoria),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
