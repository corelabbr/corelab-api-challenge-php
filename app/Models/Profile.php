<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\ProfileEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends BaseModel
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => ProfileEnum::class,
    ];

    /**
     * Obtenha os usuários associados a este perfil.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Verifique se o perfil é um administrador.
     */
    public function isAdmin(): bool
    {
        return $this->type === ProfileEnum::ADMIN;
    }

    /**
     * Verifique se o perfil é um gerente.
     */
    public function isManager(): bool
    {
        return $this->type === ProfileEnum::MANAGER;
    }

    /**
     * Verifique se o perfil é um membro.
     */
    public function isMember(): bool
    {
        return $this->type === ProfileEnum::MEMBER;
    }
}
