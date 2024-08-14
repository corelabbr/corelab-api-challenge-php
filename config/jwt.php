<?php

return [
    /*
     * JWT configuration
     */
    'issuer' => env('JWT_ISSUER', 'local jwt auth'),
    'audience' => env('JWT_AUDIENCE', 'http://localhost'),
];
