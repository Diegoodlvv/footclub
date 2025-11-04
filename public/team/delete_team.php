<?php

require_once '../../include/head2.php';

use App\Controller\ControllerTeam;
use App\RequetesTeam;

$id = $_GET['id'];
$requete = new ControllerTeam();
$team = $requete->read($id);

$requete2 = new ControllerTeam();
$requete2->delete($team);

$requete3 = new ControllerTeam();
$requete3->redirection();
