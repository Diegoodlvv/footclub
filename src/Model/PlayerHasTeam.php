<?php

namespace App\Model;

use App\Enum\EnumRolePlayer;

class PlayerHasTeam
{

    public function __construct(
        protected Team $team,
        protected Player $player,
        protected EnumRolePlayer $role
    ) {}

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $newTeam): void
    {
        $this->team = $newTeam;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $newPlayer): void
    {
        $this->player = $newPlayer;
    }

    public function getRolePlayerInTeam(): EnumRolePlayer
    {
        return $this->role;
    }

    public function setRolePlayerInTeam(EnumRolePlayer $newRole): void
    {
        $this->role = $newRole;
    }
}
