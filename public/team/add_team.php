<?php
require_once '../../include/head2.php';


use App\Model\Error;
use App\Model\Form;
use App\Model\Team;
use App\Controller\ControllerTeam;
use App\Model\Message;
use App\Model\Session;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerTeam();

$requete2 = new ControllerTeam();
$teams = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('name');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {

        $team = new Team($dataArray['name']);
        $requeteVerif = new ControllerTeam();

        if ($requeteVerif->verifExistanceTeam($team)) {

            Session::setMessage('team', false);
        } else {

            $requete->add($team);
            Session::setMessage('team', true);
        }

        ControllerTeam::redirection();
        exit;
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">



<div class="container">

    <?php if (Session::hasMessage('team') && Session::getMessageType('team')) { ?>

        <?php Message::msgSuccesTeam() ?>

    <?php } else if (Session::hasMessage('team') && Session::getMessageType('team') == 'false') { ?>

        <?php Message::msgErrorTeam() ?>

    <?php } ?>

    <?php Session::clearMessage('team'); ?>

    <h2>Liste des équipes</h2>

    <div class="players-container">
        <?php foreach ($teams as $team) { ?>
            <div class="player-card">

                <div class="player-info">
                    <h3 class="player-name" style="padding-bottom: 15px;"><?= $team->GetTeamName() ?></h3>
                    <div class="player-actions">
                        <button class="btn btn-edit"><a href="modify_team.php?id=<?= $team->getId() ?>">Modifier</a></button>
                        <button class="btn btn-delete"><a href="delete_team.php?id=<?= $team->getId() ?>">Supprimer</a></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h2 style="margin-top: 120px;">Ajouter une nouvelle équipe</h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Nom de l'équipe</label>
            <div class="input-wrap">
                <input id="firstname" name="name" type="text" placeholder="Ex. Arsenal" aria-required="true" />
            </div>
            <?php $data->getChamp('name'); ?>
        </div>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>