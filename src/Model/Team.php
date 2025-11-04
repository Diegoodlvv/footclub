<?php

namespace App\Model;


final class Team
{


    public function __construct(
        private string $name,
        private ?int $id = null
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $newId): void
    {
        $this->id = $newId;
    }

    public function GetTeamName(): string
    {
        return $this->name;
    }

    public function SetTeamName(string $newName): void
    {
        $this->name = $newName;
    }

    public static function arrayToTeam(array $data): Team
    {
        return new Team(
            $data['name'],
            $data['id']
        );
    }
}
