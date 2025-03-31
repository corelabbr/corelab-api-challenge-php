<?php

declare(strict_types = 1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    OwenIt\Auditing\AuditingServiceProvider::class,
];
