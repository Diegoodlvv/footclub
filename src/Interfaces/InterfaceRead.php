<?php

namespace App\Interfaces;

interface InterfaceRead
{
    public function readAll(): array|false;

    public function read($id): array;
}
