<?php

namespace interfaces;

interface Modify
{
    public function modify(Model $model, array $newData): void;
}
