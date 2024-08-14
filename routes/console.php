<?php

use App\Helpers\JwtHelper;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('jwt:generate', function () {
    $this->comment('Generating Jwt key pair...');
    $dir = 'jwt';

    if (!Storage::exists($dir)) {
        Storage::makeDirectory($dir);
    }

    $privateKeyPath = JwtHelper::getPrivateKeyPath();
    $publicKeyPath = JwtHelper::getPublicKeyPath();

    if (Storage::exists($privateKeyPath) && Storage::exists($publicKeyPath)) {
        if ($this->confirm('Jwt key pair already exists. Do you want to overwrite it?')) {
            Storage::delete($privateKeyPath);
            Storage::delete($publicKeyPath);
        } else {
            return;
        }
    }

    $privateKey = openssl_pkey_new([
        'private_key_bits' => 2048,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]);

    openssl_pkey_export($privateKey, $privateKeyPem);

    $publicKey = openssl_pkey_get_details($privateKey)['key'];

    Storage::write($privateKeyPath, $privateKeyPem);
    Storage::write($publicKeyPath, $publicKey);

    $this->info('Jwt key pair generated successfully!');
})->purpose('Generate JWT secret key');
