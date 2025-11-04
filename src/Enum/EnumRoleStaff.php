<?php

namespace App\Enum;

enum EnumRoleStaff: string
{
    case Entraineur = "entraineur";
    case Preparateur = "préparateur";
    case Medecin = "médecin";
}
