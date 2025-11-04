<?php

namespace App\Controller;

use App\Enum\EnumRolePlayer;
use App\Interfaces\InterfaceRead;
use App\Interfaces\InterfaceModel;
use App\Model\LoginDatabase;
use App\Model\Player;
use App\Model\PlayerHasTeam;
use App\Model\Team;

class ControllerPlayerHasTeam extends LoginDatabase implements InterfaceRead
{
    const TABLE = "player_has_team";

    public function read($id): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        $playerTeam = $requete->fetch(\PDO::FETCH_ASSOC);
        return $playerTeam;
    }

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $playersTeam = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $playersTeam;
    }

    public function bindValuePlayerHasTeam($requete, array $playerTeam)
    {
        $requete->bindValue(':player_id', $playerTeam['player_id']);
        $requete->bindValue(':team_id', $playerTeam['team_id']);
        $requete->bindValue(':role', $playerTeam['role']);
    }

    public function add(array $playerTeam): void
    {
        $requete = $this->getPdo()->prepare('INSERT INTO ' .  self::TABLE . ' (player_id, team_id, role) values (:player_id, :team_id, :role) ');
        $this->bindValuePlayerHasTeam($requete, $playerTeam);
        $requete->execute();
    }

    public function getTeams(InterfaceModel|Player $player): array
    {
        $stmt = $this->getPdo()->prepare("
            SELECT * FROM " . self::TABLE . " WHERE player_id = :player_id
        ");
        $stmt->bindValue(':player_id', $player->getId(), \PDO::PARAM_INT);
        $stmt->execute();

        $playersHasteams = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        foreach ($playersHasteams as $playerHasTeam) {
            $requete = new ControllerPlayer();

            $player = $requete->read($playerHasTeam['player_id']);

            $requete2 = new ControllerTeam();

            $team = $requete2->read($playerHasTeam['team_id']);

            $role = EnumRolePlayer::from($playerHasTeam['role']);

            $playerTeams[] = new PlayerHasTeam(
                $team,
                $player,
                $role
            );
        }

        return $playerTeams;
    }
}
