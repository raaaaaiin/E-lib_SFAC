<?php

namespace App\Installer;

class ServerRequirement
{
    public function phpExtensions()
    {
        return [
            'PHP >= 7.3.0' => version_compare(phpversion(), '7.3.0','>='),
            'Intl PHP Extension' => extension_loaded('intl'),
            //'OpenSSL PHP Extension' => extension_loaded('openssl'),
            'PDO PHP Extension' => extension_loaded('pdo'),
            'Mbstring PHP Extension' => extension_loaded('mbstring'),
            'Tokenizer PHP Extension' => extension_loaded('tokenizer'),
            'XML PHP Extension' => extension_loaded('xml'),
            'Ctype PHP Extension' => extension_loaded('ctype'),
            'JSON PHP Extension' => extension_loaded('json'),
            'FileInfo PHP Extension' => extension_loaded('fileinfo'),
            'Zip Extension' => extension_loaded('zip'),
        ];
    }

    public function directoriesPermissions()
    {
        return [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(app()->bootstrapPath('cache')),
        ];
    }

    public function pleased()
    {
        return collect($this->phpExtensions())
            ->merge($this->directoriesPermissions())
            ->every(function ($item) {
                return $item;
            });
    }
}
