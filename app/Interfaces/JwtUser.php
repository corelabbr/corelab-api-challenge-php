<?php

namespace App\Interfaces;

interface JwtUser
{
    public function getJwtId(): mixed;
    public function getJwtClaims(): array;
}
