<?php

require_once '../../include/head2.php';

use App\Controller\ControllerMatch;

$id = $_GET['id'];
$requete = new ControllerMatch();
$match = $requete->read($id);

$requete2 = new ControllerMatch();
$requete2->delete($match);

$requete3 = new ControllerMatch();
$requete3->redirection();
