<?php

namespace App\Service\Auth;

use App\Helpers\JwtHelper;
use App\Interfaces\JwtUser;
use App\Models\JwtTokens;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Timebox;
use Illuminate\Support\Traits\Macroable;

class JwtGuard implements Guard
{
    use GuardHelpers, Macroable;

    protected string $token;

    public function __construct(
        private readonly Request $request
    ) { }

    public function attempt(array $credentials = [], bool $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user === null) {
            throw new \InvalidArgumentException('User credentials invalid');
        }

        if (!$user instanceof JwtUser) {
            throw new \InvalidArgumentException('User must implement JwtUser');
        }

        if (!$this->provider->validateCredentials($user, $credentials)) {
            return false;
        }

        $this->provider->rehashPasswordIfRequired($user, $credentials);
        $this->setUser($user);
        return true;
    }

    public function user(): ?Authenticatable
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = JwtHelper::validate($this->request->bearerToken() ?? "", $tokenId);

        if (!is_null($user)) {
            JwtTokens::check($tokenId, $user->getJwtId());
            $this->setUser($user);
            return $user;
        }

        return null;
    }

    public function validate(array $credentials = []): bool
    {
        return false; // not used in jwt guard i guess
    }
}
