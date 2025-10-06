<?php

namespace App;


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

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $teams = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $teams;
    }

    public function read($id): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE . " WHERE :id = id");
        $requete->bindParam(':id', $id);
        $requete->execute();
        $team = $requete->fetch(\PDO::FETCH_ASSOC);
        return $team;
    }

    public function verifExistanceTeam(Team $team): void
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE name = :name");
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();

        if ($requete->fetch(\PDO::FETCH_ASSOC) === false) {
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
