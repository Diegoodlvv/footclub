<?php

namespace interfaces;

interface Delete
{
    public function delete(Model $model, $id): void;
}
