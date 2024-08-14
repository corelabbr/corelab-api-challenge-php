<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'completed', 'user_id',
        'favorite', 'description', 'color',
        'due_date', 'completed_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toggleCompletion(): void
    {
        $this->completed = !$this->completed;

        if ($this->completed) {
            $this->completed_at = now();
        } else {
            $this->completed_at = null;
        }

        $this->save();
    }

    public function checkOwnership($user): bool
    {
        return $this->user_id === $user->id;
    }

    public static function create(array $attributes = []): TodoItem
    {
        $instance = new self();
        $instance->fill($attributes);
        $instance->save();

        return $instance;
    }
}
