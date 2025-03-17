<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsersFactory> */
    use HasFactory;
    use HasApiTokens;

    protected $table='users';
    protected $fillable = ['nomeUser', 'email', 'senha'];
    protected $hidden = ['senha', 'remember_token'];

    protected $authPasswordName = 'senha';

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }
}
