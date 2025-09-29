<?php

namespace public;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {

            $file = str_replace('\\', DIRECTORY_SEPARATOR, '../src/' . $class) . '.php';
            var_dump($file);
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
