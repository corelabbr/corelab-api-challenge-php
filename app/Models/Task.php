<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Task extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'color_id',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_favorited',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(TaskColor::class, 'color_id');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_favorites')
            ->withTimestamps();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(TaskFavorite::class);
    }

    // Método para verificar se a tarefa está favoritada pelo usuário atual
    public function getIsFavoritedAttribute(): bool
    {
        if (! Auth::check()) {
            return false;
        }

        return $this->favoritedBy()->where('user_id', Auth::id())->exists();
    }

    public function favorite(): void
    {
        if (! $this->is_favorited && Auth::check()) {
            $this->favoritedBy()->attach(Auth::id());
        }
    }

    public function unfavorite(): void
    {
        if ($this->is_favorited && Auth::check()) {
            $this->favoritedBy()->detach(Auth::id());
        }
    }

    // Método para alternar o estado de favorito da tarefa
    public function toggleFavorite(): bool
    {
        if (! Auth::check()) {
            return false;
        }

        if ($this->is_favorited) {
            $this->unfavorite();

            return false;
        } else {
            $this->favorite();

            return true;
        }
    }
}
