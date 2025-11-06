<?php
require_once '../../include/head2.php';


use App\Model\Error;
use App\Model\Form;
use App\Model\OpposingClub;
use App\Controller\ControllerOpposingClub;
use App\Model\Message;
use App\Model\Session;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerOpposingClub();

$requete2 = new ControllerOpposingClub();
$opposing_clubs = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('name');
    $data->isEmpty('address');
    $data->isEmpty('city');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $opposing_club = new OpposingClub($dataArray['name'], $dataArray['city'], $dataArray['address']);
        $requeteVerif = new ControllerOpposingClub();
        if ($requeteVerif->verifyOpposingClub($opposing_club)) {
            $requete->add($opposing_club);

            Session::setMessage('club', true);
        } else {

            Session::setMessage('club', false);
        }

        ControllerOpposingClub::redirection();
        exit;
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <?php if (Session::hasMessage('club') && Session::getMessageType('club')) { ?>

        <?php Message::msgSuccesClub() ?>

    <?php } else if (Session::hasMessage('club') && Session::getMessageType('club') == 'false') { ?>

        <?php Message::msgErrorClub() ?>

    <?php } ?>

    <?php Session::clearMessage('club'); ?>

    <h2>Liste des équipes adverses</h2>

    <div class="players-container">

        <?php if ($opposing_clubs == false) {
            echo "Il n'y a pas encore d'équipe adverses";
        } else {

            foreach ($opposing_clubs as $opposing_club) { ?>
                <div class="player-card">

                    <div class="player-info">
                        <h3 class="player-name" style="padding-bottom: 10px;"><?= $opposing_club['object']->getName() ?></h3>
                        <p class="player-birthdate">Adresse : <?= $opposing_club['object']->getAdress() ?></p>
                        <p class="player-birthdate">Ville : <?= $opposing_club['object']->getCity() ?></p>
                        <div class="player-actions">
                            <button class="btn-edit"><a href="modify_opposing_club.php?id=<?= $opposing_club['id'] ?>">Modifier</a></button>
                            <button class="btn-delete"><a href="delete_opposing_club.php?id=<?= $opposing_club['id'] ?>">Supprimer</a></button>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>
    </div>

    <h2 style="margin-top: 120px;">Ajouter une nouvelle équipe adverse </h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Nom de l'équipe</label>
            <div class="input-wrap">
                <input id="firstname" name="name" type="text" placeholder="Ex. PSG" aria-required="true" />
            </div>
            <?php $data->getChamp('name'); ?>
        </div>

        <div>
            <label for="address">Adresse de l'équipe</label>
            <div class="input-wrap">
                <input id="address" name="address" type="text" placeholder="Ex. parc des princes" aria-required="true" />
            </div>
            <?php $data->getChamp('address'); ?>
        </div>

        <div>
            <label for="city">Ville de l'équipe</label>
            <div class="input-wrap">
                <input id="city" name="city" type="text" placeholder="Ex. Paris" aria-required="true" />
            </div>
            <?php $data->getChamp('city'); ?>
        </div>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>