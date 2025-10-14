<?php

require_once '../../include/head.php';

use App\RequetesPlayer;

$id = $_GET['id'];
$requete = new RequetesPlayer();

$requete->delete($id);
header("Location: add_player.php");
