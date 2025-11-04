<?php

require_once '../../include/head2.php';

use App\Controller\ControllerPlayer;

$id = $_GET['id'];
$requete = new ControllerPlayer();
$player = $requete->read($id);

$requete2 = new ControllerPlayer();
$requete2->delete($player);

$requete3 = new ControllerPlayer();
$requete3->redirection();
