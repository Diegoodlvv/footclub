<?php

namespace App\Controller;

use App\Interfaces\InterfaceCrud;
use App\Interfaces\InterfaceModel;
use App\Interfaces\InterfaceRead;
use App\Model\LoginDatabase;
use App\Model\Matchs;
use App\Model\OpposingClub;
use App\Model\Team;

class ControllerMatch extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    const TABLE = "matchs";


    public function bindValueMatch($requete, Matchs $match, $idClub, $idTeam): void
    {

        $requete->bindValue(':team_score', $match->getScore());
        $requete->bindValue(':opponent_score', $match->getOpponentScore());
        $requete->bindValue(':date', $match->getDate());
        $requete->bindValue(':team_id', $idTeam);
        $requete->bindValue(':city', $match->getCity());
        $requete->bindValue(':opposing_club_id', $idClub);
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
        $requete = $this->getPdo()->prepare('SELECT * FROM `' . self::TABLE . '`');
        $requete->execute();
        $matchs = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $matchs;
    }

    public function add(InterfaceModel|Matchs $match): int
    {
        $idTeam = $this->getTeamId($match->getTeam());
        $idClub = $this->getClubId($match->getOpposing_club());

        $requete = $this->getPdo()->prepare("INSERT INTO " . self::TABLE . " (team_score, opponent_score, date, team_id, city, opposing_club_id) values (:team_score, :opponent_score, :date, :team_id, :city, :opposing_club_id)");
        $this->bindValueMatch($requete, $match, $idClub, $idTeam);
        $requete->execute();
        return $this->getPdo()->lastInsertId();
    }

    public function delete($id): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
    }

    public static function redirection(): void
    {
        header("Location: add_staff.php");
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

    public function getTeamId(Team $team): int
    {
        $requete = $this->getPdo()->prepare('SELECT id FROM Team WHERE name = :name');
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();
        $idTeam = $requete->fetch(\PDO::FETCH_ASSOC);

        return $idTeam['id'];
    }

    public function getClubId(OpposingClub $opposing_club): int
    {
        var_dump($opposing_club);
        $requete = $this->getPdo()->prepare('SELECT id FROM opposing_club WHERE name = :name AND address = :address AND city = :city');
        $requete->bindValue(':name', $opposing_club->getName());
        $requete->bindValue(':address', $opposing_club->getAdress());
        $requete->bindValue(':city', $opposing_club->getCity());
        $requete->execute();
        $idClub = $requete->fetch(\PDO::FETCH_ASSOC);
        var_dump($idClub);

        return $idClub['id'];
    }
}
