<?php

namespace App\Models;

use App\Interfaces\JwtUser;
use App\Trait\JwtAuth;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JwtUser
{
    use HasFactory, Notifiable, HasUuids, JwtAuth;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's todo items.
     */
    public function todoItems(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }

    public function getJwtId(): mixed
    {
        return $this->id;
    }

    public function getJwtClaims(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public static function create(array $credentials): User
    {
        $user = new User();
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        return $user;
    }
}
