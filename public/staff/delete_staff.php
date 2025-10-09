<?php

require_once '../../head2.php';

use App\RequetesStaff;

$id = $_GET['id'];

$requete = new RequetesStaff();

$requete->delete($id);
header('Location: add_staff.php');
echo 'Le joueur a bien été supprimé';
