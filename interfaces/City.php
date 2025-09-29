<?php

namespace interfaces;

interface City
{
    public function getCity(): string;

    public function setCity(string $newCity): void;
}
