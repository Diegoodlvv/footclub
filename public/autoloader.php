<?php

namespace public;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Base directory pour les classes
            $baseDir = __DIR__ . '/../src/';

            // Remplacer les backslashes éventuels par des slashes
            $file = $baseDir . str_replace('\\', '/', $class) . '.php';

            if (file_exists($file)) {
                require_once $file;
            } else {
                // Debug optionnel (tu peux le retirer en prod)
                error_log("Classe '$class' introuvable dans $file");
            }
        });
    }
}
