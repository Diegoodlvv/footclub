<?php

require_once 'LoginDatabase.php';

class RequetesMatch extends LoginDatabase
{
    const TABLE = "match";
    private int $teamID;
    private int $opposing_club_id;

    public function __construct(int $teamID, int $opposing_club_id)
    {
        $this->teamID = $teamID;
        $this->opposing_club_id = $opposing_club_id;
    }

    public function selectTeamId(Team $team): void
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM team WHERE name = :name");
        $requete->bindParam(":name",  $team->GetTeamName());
        $requete->execute();
        $this->teamID = $requete->fetch(pdo::FETCH_ASSOC);
    }

    public function selectOpposingClubId(OpposingClub $opponent): void
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM opposing_club WHERE address = :address");
        $requete->bindParam(":address", $opponent->getAdress());
        $requete->execute();
        $this->opposing_club_id = $requete->fetch(pdo::FETCH_ASSOC);
    }

    public function bindValueMatch($requete, Matchs $match): void
    {
        $requete->bindValue(':team_score', $match->getScore());
        $requete->bindValue(':opponent_score', $match->getOpponentScore());
        $requete->bindValue(':date', $match->getDate());
        $requete->bindValue(':team_id', $this->teamID);
        $requete->bindValue(':city', $match->getCity());
        $requete->bindValue(':opposing_club_id', $this->opposing_club_id);
    }

    public function addMatch(Matchs $match)
    {
        $requete = $this->getPdo()->prepare("INSERT INTO" . self::TABLE . "(team_score, opponent_score, date, team_id, city, opposing_club_id) values (:team_score, :opponent_score, :date, :team_id, :city, :opposing_club_id)");
        $this->bindValueMatch($requete, $match);
        $requete->execute();
    }
}
