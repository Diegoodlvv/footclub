<?php

namespace interfaces;

interface Team
{
    public function getTeam(): Team;

    public function setTeam(Team $newTeam): void;
}
