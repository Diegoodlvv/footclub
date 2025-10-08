<?php

namespace App;

use App\EnumRoleStaff;

class Staff
{
    protected string $firstname;
    protected string $lastname;
    protected string $picture;
    protected EnumRoleStaff $role;

    public function __construct(string $firstname, string $lastname, string $picture, EnumRoleStaff $role)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->picture = $picture;
        $this->role = $role;
    }

    // --- GETTERS ---

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

    // --- SETTERS ---

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
}
