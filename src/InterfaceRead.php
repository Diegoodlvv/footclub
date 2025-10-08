<?php

namespace App;

interface InterfaceRead
{
    public function readAll(): array;

    public function read($id): array;
}
