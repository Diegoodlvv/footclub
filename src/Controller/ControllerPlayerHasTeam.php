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

    public function read(int|array $id): PlayerHasTeam
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE . ' WHERE player_id = :player_id AND team_id = :team_id');
        $requete->bindValue(':player_id', $id['player_id']);
        $requete->bindValue(':team_id', $id['team_id']);
        $requete->execute();
        $playerTeam = $requete->fetch(\PDO::FETCH_ASSOC);

        $playerTeam = PlayerHasTeam::arrayToPlayerHasTeam($playerTeam);

        return $playerTeam;
    }

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $playersTeam = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $playersTeam;
    }

    public static function redirection(): void
    {
        header("Location: add_player.php");
    }

    public function bindValuePlayerHasTeam($requete, InterfaceModel|PlayerHasTeam $playerHasTeam)
    {
        $requete->bindValue(':player_id', $playerHasTeam->getPlayer()->getId());
        $requete->bindValue(':team_id', $playerHasTeam->getTeam()->getId());
        $requete->bindValue(':role', $playerHasTeam->getRole()->value);
    }

    public function add(InterfaceModel|PlayerHasTeam $playerHasTeam): void
    {
        $requete = $this->getPdo()->prepare('INSERT INTO ' .  self::TABLE . ' (player_id, team_id, role) values (:player_id, :team_id, :role) ');
        $this->bindValuePlayerHasTeam($requete, $playerHasTeam);
        $requete->execute();
    }

    public function getTeams(InterfaceModel|Player $player): ?array
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

        if (!empty($playerTeams)) {
            return $playerTeams;
        } else {
            return null;
        }
    }

    public function verifyPlayerTeamRole(InterfaceModel|PlayerHasTeam $playerHasTeam): bool
    {
        $requete = $this->getPdo()->prepare("SELECT * FROM " . self::TABLE . " WHERE player_id = :player_id AND team_id = :team_id AND role = :role");
        $this->bindValuePlayerHasTeam($requete, $playerHasTeam);
        $requete->execute();
        $bool = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($bool == false) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(InterfaceModel|PlayerHasTeam $playerHasTeam): void
    {
        $requete = $this->getPdo()->prepare("DELETE FROM " . self::TABLE . " WHERE player_id = :player_id AND team_id = :team_id");
        $requete->bindValue(':player_id', $playerHasTeam->getPlayer()->getId());
        $requete->bindValue(':team_id', $playerHasTeam->getTeam()->getId());
        $requete->execute();
    }
}
