<?php

namespace App;

interface InterfaceRead
{
    public function readAll(): array|false;

    public function read($id): array;
}
