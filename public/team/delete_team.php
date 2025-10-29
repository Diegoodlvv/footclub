<?php

require_once '../../include/head2.php';

use App\Controller\ControllerTeam;
use App\RequetesTeam;

$id = $_GET['id'];
$requete = new ControllerTeam();

$requete->delete($id);
header("Location: add_team.php");
