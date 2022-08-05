<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4dfc97e92dbf2a67faab29c37f76960a
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Brian\\Crud\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Brian\\Crud\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4dfc97e92dbf2a67faab29c37f76960a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4dfc97e92dbf2a67faab29c37f76960a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4dfc97e92dbf2a67faab29c37f76960a::$classMap;

        }, null, ClassLoader::class);
    }
}