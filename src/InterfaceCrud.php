<?php

namespace App;


interface InterfaceCrud
{
    public function add(InterfaceModel $model): int;
    public function modify(InterfaceModel $model, array $newData): void;
    public function delete($id): void;
}
