<?php

namespace App\Model;

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

    public static function msgSuccesStaff(): void
    {
        echo "✅ Le membre du staff a été ajoutée avec succès !";
    }

    public static function msgErrorStaff(): void
    {
        echo "❌ Le membre du staff existe déjà dans la base de données.";
    }

    public static function msgSuccesClub(): void
    {
        echo "✅ L'équipe adverse a été ajoutée avec succès !";
    }

    public static function msgErrorClub(): void
    {
        echo "❌ L'équipe adverse existe déjà dans la base de données.";
    }

    public static function msgSuccesMatch(): void
    {
        echo "✅ Le match a été ajoutée avec succès !";
    }

    public static function msgErrorMatch(): void
    {
        echo "❌ Le match existe déjà dans la base de données.";
    }

    public static function msgErrorPlayerTeam(): void
    {
        echo "❌ Le joueur à déjà ce rôle dans cette équipe";
    }

    public static function msgSuccesPlayerTeam(): void
    {
        echo "✅ Le joueur a été ajoutée avec succès dans l'équipe choisi !";
    }
}
