<?php

namespace App\Model;

use App\Model\Team;

final class Matchs
{



    public function __construct(
        protected int $team_score,
        protected int $opponent_score,
        protected string $date,
        protected Team $team,
        protected string $city,
        protected OpposingClub $opposing_club,
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

    public function getScore(): int
    {
        return $this->team_score;
    }

    public function getOpponentScore(): int
    {
        return $this->opponent_score;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getTeamScore(): int
    {
        return $this->team_score;
    }

    public function getOpposing_club()
    {
        return $this->opposing_club;
    }

    public function setTeamScore(int $team_score): void
    {
        $this->team_score = $team_score;
    }

    public function setOpponentScore(int $opponent_score): void
    {
        $this->opponent_score = $opponent_score;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setOpposingClub(OpposingClub $opposing_club): void
    {
        $this->opposing_club = $opposing_club;
    }
}
