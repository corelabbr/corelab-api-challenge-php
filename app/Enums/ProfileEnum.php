<?php

declare(strict_types = 1);

namespace App\Enums;

enum ProfileEnum: string
{
    case ADMIN   = 'admin';
    case MANAGER = 'manager';
    case MEMBER  = 'member';
}
