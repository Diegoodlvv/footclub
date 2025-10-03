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

            // Où chercher
            $dirs = [
                __DIR__ . '/../src/',
                __DIR__ . '/../interfaces/'
            ];

            // On parcourt les dossiers
            foreach ($dirs as $dir) {
                $file = $dir . $classname . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}
