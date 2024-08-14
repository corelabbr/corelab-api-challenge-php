<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha384;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\Constraint;

class JwtHelper
{
    public static function getPrivateKeyPath(): string {
        return 'jwt/private.pem';
    }

    public static function getPublicKeyPath(): string {
        return 'jwt/public.pem';
    }

    public static function getSigner(): Sha384
    {
        return new Sha384();
    }

    public static function getPrivateKey(): InMemory
    {
        if (!Storage::exists(self::getPrivateKeyPath())) {
            throw new \InvalidArgumentException('Private key path does not exist.');
        }

        return InMemory::file(Storage::path(self::getPrivateKeyPath()));
    }

    public static function getPublicKey(): InMemory
    {
        if (!Storage::exists(self::getPublicKeyPath())) {
            throw new \InvalidArgumentException('Public key path does not exist.');
        }

        return InMemory::file(Storage::path(self::getPublicKeyPath()));
    }

    public static function getConfig(): Configuration
    {
        return Configuration::forAsymmetricSigner(
            self::getSigner(),
            self::getPrivateKey(),
            self::getPublicKey()
        );
    }

    public static function validate(string $token, ?string &$tokenId): ?User {
        $jwtFacade = new JwtFacade();
        $config = self::getConfig();

        try {
            $parsed = $jwtFacade->parse(
                $token,
                new Constraint\SignedWith($config->signer(), $config->signingKey()),
                new Constraint\StrictValidAt(SystemClock::fromUTC()),
                new Constraint\IssuedBy(config('jwt.issuer')),
                new Constraint\PermittedFor(config('jwt.audience'))
            );

            $tokenId = $parsed->claims()->get('jti');
            return User::where('id', $parsed->claims()->get('sub'))->first();
        } catch (RequiredConstraintsViolated|InvalidTokenStructure) {
            return null;
        }
    }
}
