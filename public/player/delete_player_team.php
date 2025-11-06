<?php

require_once '../../include/head2.php';

use App\Controller\ControllerPlayerHasTeam;
use App\Model\PlayerHasTeam;

$key = [
    'player_id' => $_GET['playerId'],
    'team_id' => $_GET['teamId']
];

$playerHasTeam = new ControllerPlayerHasTeam()->read($key);

$deleting = new ControllerPlayerHasTeam()->delete($playerHasTeam);

ControllerPlayerHasTeam::redirection();
