<?php

namespace App;

class Message
{

    public static function msgSuccesTeam(): void
    {
        echo "✅ L'équipe a été ajoutée avec succès !";
    }

    public static function msgErrorTeam(): void
    {
        echo "❌ L'équipe existe déjà dans la base de données.";
    }

    public static function msgSuccesPlayer(): void
    {
        echo "✅ Le joueur a été ajoutée avec succès !";
    }

    public static function msgErrorPlayer(): void
    {
        echo "❌ Le joueur existe déjà dans la base de données.";
    }
}
