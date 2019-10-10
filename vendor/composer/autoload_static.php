<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit93ff6d8c7db9cacc138ce185d6ad3047
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Ultraleet\\WP\\VerifyOnce\\' => 24,
            'Ultraleet\\WP\\Settings\\' => 22,
            'Ultraleet\\WP\\' => 13,
            'Ultraleet\\VerifyOnce\\' => 21,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'M' => 
        array (
            'MyCLabs\\Enum\\' => 13,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ultraleet\\WP\\VerifyOnce\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'Ultraleet\\WP\\Settings\\' => 
        array (
            0 => __DIR__ . '/..' . '/ultraleet/wp-settings/src',
        ),
        'Ultraleet\\WP\\' => 
        array (
            0 => __DIR__ . '/..' . '/ultraleet/wp-requirements-checker/src',
        ),
        'Ultraleet\\VerifyOnce\\' => 
        array (
            0 => __DIR__ . '/..' . '/ultraleet/verify-once/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'MyCLabs\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/myclabs/php-enum/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit93ff6d8c7db9cacc138ce185d6ad3047::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit93ff6d8c7db9cacc138ce185d6ad3047::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
