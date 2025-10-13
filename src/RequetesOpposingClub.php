<?php

namespace App;

class RequetesOpposingClub extends LoginDatabase implements InterfaceCrud, InterfaceRead
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

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $opposing_clubs = $requete->fetch(\PDO::FETCH_ASSOC);
        return $opposing_clubs;
    }

    public function add(InterfaceModel|OpposingClub $opposing_club): int
    {
        $requete = $this->getPdo()->prepare('INSERT INTO ' . self::TABLE . ' VALUES (:city, :address)');
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
