<?php

namespace App;


use App\InterfaceCrud;
use App\InterfacesModel;
use App\InterfaceRead;
use App\RequetesTeam;

class RequetesMatch extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    const TABLE = "match";


    public function bindValueMatch($requete, Matchs $match): void
    {
        $requeteTeam = new RequetesTeam();
        $idTeam = $requeteTeam->readTeamID($match->getTeam()->GetTeamName());


        $requete->bindValue(':team_score', $match->getScore());
        $requete->bindValue(':opponent_score', $match->getOpponentScore());
        $requete->bindValue(':date', $match->getDate());
        $requete->bindValue(':team_id', $idTeam);
        $requete->bindValue(':city', $match->getCity());
        $requete->bindValue(':opposing_club_id', $match->getOpposing_club());
    }

    public function read($id): array
    {
        $requete = $this->getPdo()->prepare("SELECT * FROM " . self::TABLE .  " WHERE id = :id");
        $requete->bindParam(":id",  $id);
        $requete->execute();
        $match = $requete->fetch(\PDO::FETCH_ASSOC);
        return $match;
    }

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $matchs = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $matchs;
    }

    public function add(InterfaceModel|Matchs $match): int
    {
        $requete = $this->getPdo()->prepare("INSERT INTO" . self::TABLE . "(team_score, opponent_score, date, team_id, city, opposing_club_id) values (:team_score, :opponent_score, :date, :team_id, :city, :opposing_club_id)");
        $this->bindValueMatch($requete, $match);
        $requete->execute();
        return $this->getPdo()->lastInsertId();
    }

    public function delete($id): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
    }

    public function modify(InterfaceModel|Matchs $match, array $newDataMatch): void
    {
        // $city = $match->getCity();
        // $date = $match->getDate();
        // $opponent_score = $match->getOpponentScore();
        // $team_score = $match->getTeamScore();

        // $match->setCity($newDataMatch['city']);
        // $match->setDate($newDataMatch['date']);
        // $match->setOpponentScore($newDataMatch['opponent_score']);
        // $match->setTeamScore($newDataMatch['team_score']);

        // $requete = $this->getPdo()->prepare('UPDATE ' . self::TABLE . ' SET ')
    }
}
