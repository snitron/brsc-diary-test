<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdeecd950229a7e0d0890a19f3901cf77
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\DomCrawler\\' => 29,
            'Symfony\\Component\\CssSelector\\' => 30,
            'Symfony\\Component\\BrowserKit\\' => 29,
            'Snoopy\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
            'Goutte\\' => 7,
        ),
        'D' => 
        array (
            'DiDom\\' => 6,
        ),
        'B' => 
        array (
            'Behat\\Mink\\Driver\\' => 18,
            'Behat\\Mink\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\DomCrawler\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dom-crawler',
        ),
        'Symfony\\Component\\CssSelector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/css-selector',
        ),
        'Symfony\\Component\\BrowserKit\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/browser-kit',
        ),
        'Snoopy\\' => 
        array (
            0 => __DIR__ . '/..' . '/pherum/snoopy/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
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
        'Goutte\\' => 
        array (
            0 => __DIR__ . '/..' . '/fabpot/goutte/Goutte',
        ),
        'DiDom\\' => 
        array (
            0 => __DIR__ . '/..' . '/imangazaliev/didom/src/DiDom',
        ),
        'Behat\\Mink\\Driver\\' => 
        array (
            0 => __DIR__ . '/..' . '/behat/mink-browserkit-driver/src',
            1 => __DIR__ . '/..' . '/behat/mink-goutte-driver/src',
        ),
        'Behat\\Mink\\' => 
        array (
            0 => __DIR__ . '/..' . '/behat/mink/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'Curl' => 
            array (
                0 => __DIR__ . '/..' . '/lib/curl/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdeecd950229a7e0d0890a19f3901cf77::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdeecd950229a7e0d0890a19f3901cf77::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitdeecd950229a7e0d0890a19f3901cf77::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
