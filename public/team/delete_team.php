<?php

require_once '../../head.php';

use App\RequetesTeam;

$id = $_GET['id'];
$requete = new RequetesTeam();

$requete->delete($id);
header("Location: add_team.php");
