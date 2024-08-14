<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JwtTokens extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jwt_tokens';

    protected $fillable = [
        'user_id',
        'description',
        'permissions',
        'expires_at',
        'last_used_at',
    ];

    public static function add($user_id, $email, $expire, $action = 'authentication'): JwtTokens
    {
        $date = new \DateTimeImmutable();

        $token = new JwtTokens();

        $token->user_id = $user_id;
        $token->description = sprintf('%s %s', $action, $email);
        $token->permissions = null;
        $token->expires_at = $date->modify($expire);
        $token->last_used_at = null;

        $token->save();

        return $token;
    }

    public static function check(string $tokenId, string $userId): bool
    {
        return JwtTokens::where('id', $tokenId)
            ->where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->exists();
    }

    public static function remove(string $tokenId, string $userId): void
    {
        $token = JwtTokens::where('id', $tokenId)
            ->where('user_id', $userId)
            ->first();

        if ($token) {
            $token->delete();
        }
    }
}
