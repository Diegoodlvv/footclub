<?php

namespace App\Interfaces;


interface InterfaceCrud
{
    public function add(InterfaceModel $model): int;
    public function modify(InterfaceModel $model, array $newData): void;
    public function delete(InterfaceModel $model): void;
}
