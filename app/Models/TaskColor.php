<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskColor extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex_code',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtenha as tarefas associadas a esta cor.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'color_id');
    }

    /**
     * Cria um escopo de uma consulta para incluir apenas cores ativas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
