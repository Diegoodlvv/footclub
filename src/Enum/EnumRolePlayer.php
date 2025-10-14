<?php

namespace App\Enum;

enum EnumRolePlayer: string
{
    case Attaquant = "attaquant";
    case Defenseur = "defenseur";
    case Milieu = "milieu de terrain";
    case Gardien = "gardien de but";
}
