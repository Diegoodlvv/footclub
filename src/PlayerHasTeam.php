<?php

namespace App;

use interfaces\Team;

class PlayerHasTeam implements Team
{
    public array $roles = [
        "Attaquant",
        "Milieu",
        "Defenseur",
        "Gardien"
    ];
    public string $role;
    public Team $team;
    public Player $player;



    public function __construct(Team $team, Player $player, string $role)
    {
        $this->team = $team;
        $this->player = $player;
        $this->role = $role;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $newTeam): void
    {
        $this->team = $newTeam;
    }

    public function verifRole(): void
    {

        if (!in_array($this->role, $this->roles)) {
            echo "Ce role n'existe pas";
        }
    }
}
