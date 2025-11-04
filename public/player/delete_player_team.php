<?php

require_once '../../include/head2.php';

use App\Controller\ControllerPlayerHasTeam;

$idPlayer = $_GET['playerId'];
$teamId = $_GET['teamId'];


$requete = new ControllerPlayerHasTeam();
$player = $requete->read($id);

$requete2 = new ControllerPlayerHasTeam();
$requete2->delete($player);

$requete3 = new ControllerPlayerHasTeam();
$requete3->redirection();
