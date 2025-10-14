<?php

namespace App\Controller;

use App\Interfaces\InterfaceCrud;
use App\Interfaces\InterfaceModel;
use App\Interfaces\InterfaceRead;
use App\Model\LoginDatabase;
use App\Model\OpposingClub;

class ControllerOpposingClub extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    protected const TABLE = 'opposing_club';

    public function read($id): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        $opposingClub = $requete->fetch(\PDO::FETCH_ASSOC);
        return $opposingClub;
    }

    public function readAll(): array|false
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $opposing_clubs = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $opposing_clubs;
    }

    public function verifyOpposingClub(OpposingClub $opposing_club): bool
    {
        $requete = $this->getPdo()->prepare('SELECT id FROM ' . self::TABLE . ' WHERE name = :name AND address = :address AND city= :city');
        $requete->bindValue(':name', $opposing_club->getName());
        $requete->bindValue(':city', $opposing_club->getCity());
        $requete->bindValue(':address', $opposing_club->getAdress());
        $requete->execute();

        var_dump($requete->fetch(\PDO::FETCH_ASSOC) === false);
        if ($requete->fetch(\PDO::FETCH_ASSOC) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function add(InterfaceModel|OpposingClub $opposing_club): int
    {
        $requete = $this->getPdo()->prepare('INSERT INTO ' . self::TABLE . ' VALUES (0,:name,:city, :address)');
        $requete->bindValue(':name', $opposing_club->getName());
        $requete->bindValue(':city', $opposing_club->getCity());
        $requete->bindValue(':address', $opposing_club->getAdress());
        $requete->execute();
        return $this->getPdo()->lastInsertId();
    }

    public function delete($id): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
    }

    public function modify(InterfaceModel|OpposingClub $opposing_club, array $newClubData): void {}
}
