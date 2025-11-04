<?php

require_once '../../include/head2.php';

use App\Controller\ControllerStaff;

$id = $_GET['id'];
$requete = new ControllerStaff();
$staff_member = $requete->read($id);

$requete2 = new ControllerStaff();
$requete2->delete($staff_member);

$requete3 = new ControllerStaff();
$requete3->redirection();
