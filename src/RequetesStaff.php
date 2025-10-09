<?php

namespace App;

use App\LoginDatabase;
use App\InterfaceCrud;
use App\InterfaceRead;
use App\Staff;


class RequetesStaff extends LoginDatabase implements InterfaceCrud, InterfaceRead
{
    protected const TABLE = "staff_member";

    public function bindValueStaff($requete, InterfaceModel|Staff $staff_member): void
    {
        $requete->bindValue(':firstname', $staff_member->getFirstname());
        $requete->bindValue(':lastname', $staff_member->getLastname());
        $requete->bindValue(':picture', $staff_member->getPicture());
        $requete->bindValue(':role', $staff_member->getRole()->value);
    }

    public function verifyExistanceStaff(Staff $staff_member): bool
    {
        $requete = $this->getPdo()->prepare("SELECT id FROM " . self::TABLE . " WHERE firstname = :firstname AND lastname = :lastname AND picture = :picture AND role = :role");
        $this->bindValueStaff($requete, $staff_member);
        $requete->execute();

        if ($requete->fetch(\PDO::FETCH_ASSOC) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function add(InterfaceModel|Staff $staff_member): int
    {
        $requete = $this->getPdo()->prepare('INSERT INTO ' . self::TABLE . ' (id, firstname, lastname, picture, role) VALUES (0, :firstname, :lastname, :picture, :role)');
        $this->bindValueStaff($requete, $staff_member);
        $requete->execute();
        $StaffId = $this->getPdo()->lastInsertId();
        return $StaffId;
    }

    public function delete($id): void
    {
        $requete = $this->getPdo()->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
    }

    public function modify(InterfaceModel|Staff $staff_member, array $newStaffData): void
    {
        $staff_member->setFirstname($newStaffData['firstname']);
        $staff_member->setLastname($newStaffData['lastname']);
        $staff_member->setPicture($newStaffData['picture']);
        $staff_member->setRole($newStaffData['role']);

        $requete = $this->getPdo()->prepare('UPDATE ' . self::TABLE . ' SET firstname = :firstname, lastname = :lastname, picture = :picture, role = :role WHERE firstname = :BeforeFirstname, lastname = :BeforeLastname, picture = :BeforePicture, role = :BeforeRole');
        $requete->bindValue(':firstname', $newStaffData['firstname']);
        $requete->bindValue(':lastname', $newStaffData['lastname']);
        $requete->bindValue(':picture', $newStaffData['picture']);
        $requete->bindValue(':role', $newStaffData['role']);
    }

    public function read($id): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM  ' . self::TABLE . ' WHERE id = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetch(\PDO::FETCH_ASSOC);
    }

    public function readAll(): array
    {
        $requete = $this->getPdo()->prepare('SELECT * FROM ' . self::TABLE);
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_ASSOC);
    }
}
