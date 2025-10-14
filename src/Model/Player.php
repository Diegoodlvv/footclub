<?php

namespace App\Model;

final class Player
{
    protected string $firstname;
    protected string $lastname;
    protected string $birthdate;
    protected string $picture;

    public function __construct(string $firstname, string $lastname, string $birthdate, string $picture)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }

    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setFirstName(string $name): void
    {
        $this->firstname = $name;
    }

    public function setLastName(string $name): void
    {
        $this->lastname = $name;
    }

    public function setBirthdate(string $date): void
    {
        $this->birthdate = $date;
    }

    public function setPicture(string $pic): void
    {
        $this->picture = $pic;
    }


    public static function arrayToPlayer(array $dataPlayer): Player
    {
        return new Player(
            $dataPlayer["firstname"],
            $dataPlayer["lastname"],
            $dataPlayer["birthdate"],
            $dataPlayer["picture"]
        );
    }
}
