<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    public function authenticate(array $credentials): ?array;
}