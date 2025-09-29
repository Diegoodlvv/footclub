<?php

require_once 'LoginDatabase.php';

class RequetesTeam extends LoginDatabase
{
    protected const TABLE = "team";

    public function addTeam(Team $team): void
    {
        $requete = $this->getPdo()->prepare("INSERT INTO " . self::TABLE . "(name) values (:name)");
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();
    }

    public function redirection(): void
    {
        header("Location: ../");
    }

    public function verifExistanceTeam(Team $team): void
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE name = :name");
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();

        if ($requete->fetch(PDO::FETCH_ASSOC) === false) {
            $this->addTeam($team);
        } else {
            echo "Cette équipe a déjà été renseignée </br>";
        }
    }

    public function deleteTeam(Team $team): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM' . self::TABLE . 'WHERE name = :name');
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();
        header("Location: Team.php");
    }

    public function modifyTeam(Team $team, string $newTeamName): void
    {
        $newTeam = $team->SetTeamName($newTeamName);
        $requete = $this->getPdo()->prepare('UPDATE' . self::TABLE . 'SET name = :name');
        $requete->bindValue(':name', $newTeam);
    }
}
