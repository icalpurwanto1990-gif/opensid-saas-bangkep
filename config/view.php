<?php

/*
 * Konfigurasi View Blade OpenSID & Multi-Tenant Diskominfo
 * Menjamin direktori cache views selalu ada dan writable oleh web server (www-data)
 */

$defaultViewsDir = storage_path('framework/views');

if (! is_dir($defaultViewsDir)) {
    @mkdir($defaultViewsDir, 0777, true);
}
@chmod($defaultViewsDir, 0777);

// Tentukan path kompilasi Blade yang dijamin memiliki izin tulis
$compiledPath = getenv('VIEW_COMPILED_PATH');

if (! $compiledPath) {
    if (is_dir($defaultViewsDir) && is_writable($defaultViewsDir)) {
        $compiledPath = realpath($defaultViewsDir) ?: $defaultViewsDir;
    } else {
        // Fallback otomatis ke direktori sementara sistem jika storage di-lock oleh root
        $fallbackDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'opensid_views';
        if (! is_dir($fallbackDir)) {
            @mkdir($fallbackDir, 0777, true);
        }
        @chmod($fallbackDir, 0777);
        $compiledPath = realpath($fallbackDir) ?: $fallbackDir;
    }
}

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => $compiledPath,
];
