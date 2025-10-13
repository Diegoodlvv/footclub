<?php

namespace App;



final class OpposingClub
{

    protected string $adress;
    protected string $city;

    public function __construct(string $adress, string $city)
    {
        $this->adress = $adress;
        $this->city = $city;
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
