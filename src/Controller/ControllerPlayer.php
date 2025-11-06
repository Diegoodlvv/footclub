<?php

namespace App\Controller;

use App\Interfaces\InterfaceCrud;
use App\Interfaces\InterfaceRead;
use App\Interfaces\InterfaceModel;
use App\Model\LoginDatabase;
use App\Model\Player;

class ControllerPlayer extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    const TABLE = "player";

    protected function bindValuePlayer($requete, InterfaceModel|Player $player): void
    {
        $requete->bindValue(':firstname', $player->getFirstName());
        $requete->bindValue(':lastname', $player->getLastName());
        $requete->bindValue(':birthdate', $player->getBirthdate());
        $requete->bindValue(':picture', $player->getPicture());
    }

    public static function redirection(): void
    {
        header("Location: add_player.php");
    }

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        $rows = $requete->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $players[] = Player::arrayToPlayer($row);
        }

        return $players;
    }

    public function read(int|array $id): InterfaceModel|Player
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE . " WHERE :id = id");
        $requete->bindParam(':id', $id);
        $requete->execute();
        $player = $requete->fetch(\PDO::FETCH_ASSOC);

        $player = Player::arrayToPlayer($player);

        return $player;
    }

    public function add(InterfaceModel|Player $player): int
    {
        $requete = $this->getPdo()->prepare("INSERT INTO " . self::TABLE . " (firstname, lastname, birthdate, picture) values(:firstname, :lastname, :birthdate, :picture)");
        $this->bindValuePlayer($requete, $player);
        $requete->execute();
        $playerId = $this->pdo->lastInsertId();
        return $playerId;
    }

    public function verifExistancePlayer(Player $player): bool
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE firstname = :firstname AND lastname = :lastname  AND birthdate = :birthdate AND picture = :picture");
        $this->bindValuePlayer($requete, $player);
        $requete->execute();
        $isPlayer = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($isPlayer == true) {

            return true;
        } else {

            return false;
        }
    }

    public function delete(InterfaceModel|Player $player): void
    {
        $requete = $this->getPdo()->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $requete->bindValue(':id', $player->getId());
        $requete->execute();
    }

    public function modify(InterfaceModel|Player $player, array $newPlayerData): void
    {
        $playerFirstName = $player->getFirstName();
        $playerLastName = $player->getLastName();
        $playerBirthdate = $player->getBirthdate();
        $playerPicture = $player->getPicture();



        $requete = $this->getPdo()->prepare("UPDATE " . self::TABLE . " SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate, picture = :picture  WHERE firstname = :beforeFirstname AND lastname = :beforeLastname AND birthdate = :beforeBirthdate AND picture = :beforePicture");
        $requete->bindValue(':firstname', $newPlayerData['firstname']);
        $requete->bindValue(':lastname', $newPlayerData['lastname']);
        $requete->bindValue(':birthdate', $newPlayerData['birthdate']);
        $requete->bindValue(':picture', $playerPicture);

        $requete->bindValue(':beforeFirstname', $playerFirstName);
        $requete->bindValue(':beforeLastname', $playerLastName);
        $requete->bindValue(':beforeBirthdate', $playerBirthdate);
        $requete->bindValue(':beforePicture', $playerPicture);
        $requete->execute();

        $player->setFirstName($newPlayerData['firstname']);
        $player->setLastName($newPlayerData['lastname']);
        $player->setBirthdate($newPlayerData['birthdate']);
    }
}
