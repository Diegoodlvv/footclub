<?php

namespace App\Model;

use App\Enum\EnumRoleStaff;

final class Staff
{
    public function __construct(
        protected string $firstname,
        protected string $lastname,
        protected string $picture,
        protected EnumRoleStaff $role,
        protected ?int $id = null
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $newId): void
    {
        $this->id = $newId;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getRole(): EnumRoleStaff
    {
        return $this->role;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function setRole(EnumRoleStaff $role): void
    {
        $this->role = $role;
    }

    public static function arrayToStaff(array $data): Staff
    {
        $staff_member = new Staff(
            $data['firstname'],
            $data['lastname'],
            $data['picture'],
            $data['role'],
            $data['id']
        );

        return $staff_member;
    }
}
