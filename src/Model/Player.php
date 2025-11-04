<?php

namespace App\Model;

final class Player
{


    public function __construct(
        protected string $firstname,
        protected string $lastname,
        protected string $birthdate,
        protected string $picture,
        protected ?int $id = null
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $newId): void
    {
        $this->id = $newId;
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
