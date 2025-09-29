<?php
require_once('Player.php');
require_once('includes/RequetesPlayer.php');
require_once('Team.php');
require_once('includes/RequetesTeam.php');

//ajoutsTeam

$team3 = new Team('PSG');
$requeteTeam3 = new RequetesTeam();
$requeteTeam3->verifExistanceTeam($team3);

//ajouts Team

$player3 = new Player('nameplayer3', 'surnameplayer3', new DateTime("2004-08-19"), 'player3.png');
$requete3 = new RequetesPlayer();

$player4 = new Player('nameplayer4', 'surnameplayer4', new DateTime("2002-08-15"), 'player4.png');

$requete3->verifExistancePlayer($player3);
