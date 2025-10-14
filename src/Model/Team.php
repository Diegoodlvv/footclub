<?php

namespace App\Model;


final class Team
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function GetTeamName(): string
    {
        return $this->name;
    }

    public function SetTeamName(string $newName): void
    {
        $this->name = $newName;
    }

    public static function arrayToTeam(array $dataTeam): Team
    {
        return new Team(
            $dataTeam['name']
        );
    }
}
