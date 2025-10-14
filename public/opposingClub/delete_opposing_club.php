<?php

require_once '../../include/head2.php';

use App\RequetesOpposingClub;

$id = $_GET['id'];

$requete = new RequetesOpposingClub();
$requete->delete($id);
header("Location: add_opposing_club.php");
