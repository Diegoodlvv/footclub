<?php

namespace App\Model;


class Session
{

    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function stop()
    {
        if (session_start()) {
            session_destroy();
        }
    }

    public static function setMessage(string $class, bool $success)
    {
        $_SESSION["message_$class"] = $success ? 'true' : 'false';
    }

    public static function hasMessage(string $class): bool
    {
        return isset($_SESSION["message_$class"]);
    }

    public static function getMessageType(string $class): string
    {
        return $_SESSION["message_$class"];
    }

    public static function clearMessage(string $class): void
    {
        unset($_SESSION["message_$class"]);
    }
}
