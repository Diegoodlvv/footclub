<?php

namespace public;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Retire le namespace racine (ex: "App\" ou "interfaces\")
            $parts = explode('\\', $class);
            $classname = array_pop($parts); // garde seulement le nom de la classe

            $file = __DIR__ . '/src/' . $classname . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        });
    }
}
