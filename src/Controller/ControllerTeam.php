<?php

namespace App\Controller;

use App\Interfaces\InterfaceCrud;
use App\Interfaces\InterfaceModel;
use App\Interfaces\InterfaceRead;
use App\Model\LoginDatabase;
use App\Model\Team;


class ControllerTeam extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    protected const TABLE = "team";

    public function add(InterfaceModel|Team $team): int
    {
        $requete = $this->getPdo()->prepare("INSERT INTO " . self::TABLE . "(name) values (:name)");
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();
        $idTeam = $this->getPdo()->lastInsertId();
        return $idTeam;
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

    public function verifExistanceTeam(Team $team): bool
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE name = :name");
        $requete->bindValue(':name', $team->GetTeamName());
        $requete->execute();

        if ($requete->fetch(\PDO::FETCH_ASSOC) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function delete($id): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        header("Location: add_team.php");
    }

    public function modify(InterfaceModel|Team $team, array $newTeamData): void
    {
        $team->SetTeamName($newTeamData['name']);
        $requete = $this->getPdo()->prepare('UPDATE ' . self::TABLE . ' SET name = :name');
        $requete->bindValue(':name', $newTeamData['name']);
        $requete->execute();
    }

    public function readTeamID(string $name): int
    {
        $requete = $this->getPdo()->prepare('SELECT id FROM ' . self::TABLE . ' WHERE name = :name');
        $requete->bindParam(':name', $name);
        $id = $requete->fetch(\PDO::FETCH_ASSOC);
        return $id;
    }
}
