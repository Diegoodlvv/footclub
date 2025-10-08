<?php

namespace App;


use App\InterfaceModel;
use App\InterfaceRead;

class RequetesPlayerHasTeam extends LoginDatabase implements InterfaceRead
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
}
