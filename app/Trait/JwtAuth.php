<?php

namespace App\Trait;

use App\Helpers\JwtHelper;
use App\Models\JwtTokens;

trait JwtAuth
{
    public function createToken(string $action = 'authToken', string $expiration = '+1 week'): string
    {
        $config = JwtHelper::getConfig();
        $date = new \DateTimeImmutable();

        $dbToken = JwtTokens::add($this->getJwtId(), $this->email, $expiration, $action);

        $builder = $config->builder()
            ->issuedBy(config('jwt.issuer'))
            ->permittedFor(config('jwt.audience'))
            ->identifiedBy($dbToken->id)
            ->relatedTo($this->getJwtId())
            ->issuedAt($date)
            ->canOnlyBeUsedAfter($date)
            ->expiresAt($date->modify($expiration));

        foreach ($this->getJwtClaims() as $key => $value) {
            $builder->withClaim($key, $value);
        }

        $token = $builder->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }

    /**
     * @throws \Exception
     */
    public function destroyToken(string $tokenString): void
    {
        if (empty($tokenString)) {
            throw new \Exception('Token string is empty');
        }

        $config = JwtHelper::getConfig();
        $token = $config->parser()->parse($tokenString);

        if (!method_exists($token, 'claims')) {
            throw new \Exception("Invalid Token", 1);
        }

        $subject = $token->claims()->get('sub');
        $tokenId = $token->claims()->get('jti');

        if (!$subject || !$tokenId || $this->getJwtId() !== $subject) {
            throw new \Exception('Invalid token');
        }

        JwtTokens::remove($tokenId, $subject);
    }
}
