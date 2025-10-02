<?php

namespace App;

use interfaces\Add;
use interfaces\Model;
use interfaces\Delete;
use interfaces\Modify;

class RequetesPlayer extends LoginDatabase implements Add, Delete, Modify
{
    const TABLE = "player";

    protected function bindValuePlayer($requete, Model|Player $player): void
    {
        $requete->bindValue(':firstname', $player->getFirstName());
        $requete->bindValue(':lastname', $player->getLastName());
        $requete->bindValue(':birthdate', $player->getBirthdate());
        $requete->bindValue(':picture', $player->getPicture());
    }

    public function redirection(): void
    {
        header("Location: ../player.php");
    }

    public function add(Model|Player $player): void
    {
        $requete = $this->getPdo()->prepare("INSERT INTO " . self::TABLE . " (firstname, lastname, birthdate, picture) values(:firstname, :lastname, :birthdate, :picture)");
        $this->bindValuePlayer($requete, $player);
        $requete->execute();
    }

    public function verifExistancePlayer(Player $player): void
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE firstname = :firstname AND lastname = :lastname  AND birthdate = :birthdate AND picture = :picture");
        $this->bindValuePlayer($requete, $player);
        $requete->execute();
        $isPlayer = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($isPlayer == false) {
            $this->add($player);
        } else {
            echo "Ce joueur a déjà été renseigné </br>";
        }
    }

    public function delete(Model $player, $id): void
    {
        $requete = $this->getPdo()->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        $this->redirection();
    }

    public function modify(Model|Player $player, array $newPlayerData): void
    {
        $playerFirstName = $player->getFirstName();
        $playerLastName = $player->getLastName();
        $playerBirthdate = $player->getBirthdate();
        $playerPicture = $player->getPicture();

        $player->setFirstName($newPlayerData['firstname']);
        $player->setLastName($newPlayerData['lastname']);
        $player->setBirthdate($newPlayerData['birthdate']);
        $player->setPicture($newPlayerData['picture']);

        $requete = $this->getPdo()->prepare("UPDATE " . self::TABLE . " SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate, picture = :picture WHERE firstname = :beforeFirstname AND lastname = :beforeLastname AND birthdate = :beforeBirthdate AND picture = :beforePicture");
        $requete->bindValue(':firstname', $player->getFirstName());
        $requete->bindValue(':lastname', $player->getLastName());
        $requete->bindValue(':birthdate', $player->getBirthdate());
        $requete->bindValue(':picture', $player->getPicture());

        $requete->bindValue(':beforeFirstname', $playerFirstName);
        $requete->bindValue(':beforeLastname', $playerLastName);
        $requete->bindValue(':beforeBirthdate', $playerBirthdate);
        $requete->bindValue(':beforePicture', $playerPicture);
        $requete->execute();
    }
}
