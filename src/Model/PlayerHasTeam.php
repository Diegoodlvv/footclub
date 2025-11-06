<?php

namespace App\Model;

use App\Enum\EnumRolePlayer;
use App\Controller\ControllerPlayer;
use App\Controller\ControllerTeam;

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

    public function getRole(): EnumRolePlayer
    {
        return $this->role;
    }

    public function setRole(EnumRolePlayer $newRole): void
    {
        $this->role = $newRole;
    }

    public static function arrayToPlayerHasTeam(array $dataPlayerTeam): PlayerHasTeam
    {
        $player = new ControllerPlayer()->read($dataPlayerTeam['player_id']);
        $team = new ControllerTeam()->read($dataPlayerTeam['team_id']);
        $role = EnumRolePlayer::from($dataPlayerTeam['role']);

        return new PlayerHasTeam(
            $team,
            $player,
            $role
        );
    }
}
