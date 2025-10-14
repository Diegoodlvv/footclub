<?php

namespace App;



final class OpposingClub
{
    protected string $name;
    protected string $adress;
    protected string $city;

    public function __construct(string $name, string $adress, string $city)
    {
        $this->name = $name;
        $this->adress = $adress;
        $this->city = $city;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAdress(): string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}
