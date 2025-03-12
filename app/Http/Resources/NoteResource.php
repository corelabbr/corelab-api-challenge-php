<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'category'      => $this->category,
            'id_user'       => $this->id_user,
            'favorite'      => $this->favorite ? true : false,
            'color'         => $this->color ?? '#FFFF',
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
