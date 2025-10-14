<?php

require_once '../../include/head2.php';

use App\Controller\ControllerPlayer;

$id = $_GET['id'];
$requete = new ControllerPlayer();

$requete->delete($id);
header("Location: add_player.php");
