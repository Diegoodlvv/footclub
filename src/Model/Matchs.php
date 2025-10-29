<?php

namespace App\Model;

use App\Model\Team;

final class Matchs
{

    private int $team_score;
    private int $opponent_score;
    private string $date;
    private Team $team;
    private string $city;
    private OpposingClub $opposing_club;

    public function __construct(int $team_score, int $opponent_score, string $date, Team $team, string $city, OpposingClub $opposing_club)
    {
        $this->team_score = $team_score;
        $this->opponent_score = $opponent_score;
        $this->date = $date;
        $this->team = $team;
        $this->city = $city;
        $this->opposing_club = $opposing_club;
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

    public function setDate(\DateTime $date): void
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
