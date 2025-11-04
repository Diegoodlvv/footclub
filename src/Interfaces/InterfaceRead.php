<?php

namespace App\Interfaces;

interface InterfaceRead
{
    public function readAll(): ?array;

    public function read($id);
}
