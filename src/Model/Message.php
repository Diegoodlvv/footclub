<?php

namespace App\Model;

class Message
{
    private static function render(string $type, string $text): void
    {
        $class = $type === 'success' ? 'success-message' : 'error-message';
        echo "<div class='{$class}'>{$text}</div>";
    }

    public static function msgSuccesTeam(): void
    {
        self::render('success', "✅ L'équipe a été ajoutée avec succès !");
    }

    public static function msgErrorTeam(): void
    {
        self::render('error', "❌ L'équipe existe déjà dans la base de données.");
    }

    public static function msgSuccesPlayer(): void
    {
        self::render('success', "✅ Le joueur a été ajouté avec succès !");
    }

    public static function msgErrorPlayer(): void
    {
        self::render('error', "❌ Le joueur existe déjà dans la base de données.");
    }

    public static function msgSuccesStaff(): void
    {
        self::render('success', "✅ Le membre du staff a été ajouté avec succès !");
    }

    public static function msgErrorStaff(): void
    {
        self::render('error', "❌ Le membre du staff existe déjà dans la base de données.");
    }

    public static function msgSuccesClub(): void
    {
        self::render('success', "✅ L'équipe adverse a été ajoutée avec succès !");
    }

    public static function msgErrorClub(): void
    {
        self::render('error', "❌ L'équipe adverse existe déjà dans la base de données.");
    }

    public static function msgSuccesMatch(): void
    {
        self::render('success', "✅ Le match a été ajouté avec succès !");
    }

    public static function msgErrorMatch(): void
    {
        self::render('error', "❌ Le match existe déjà dans la base de données.");
    }

    public static function msgSuccesPlayerTeam(): void
    {
        self::render('success', "✅ Le joueur a été ajouté avec succès dans l'équipe choisie !");
    }

    public static function msgErrorPlayerTeam(): void
    {
        self::render('error', "❌ Le joueur a déjà ce rôle dans cette équipe.");
    }
}
