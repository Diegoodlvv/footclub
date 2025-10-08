<?php
require_once '../head2.php';


use App\Error;
use App\Form;
use App\Team;
use App\RequetesTeam;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new RequetesTeam();

$requete2 = new RequetesTeam();
$teams = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('name');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $team = new Team($dataArray['name']);
        $requeteVerif = new RequetesTeam();
        if ($requeteVerif->verifExistanceTeam($team)) {
            echo "L'équipe a déjà été ajouté auparavant";
        } else {
            $requete->add($team);
            echo "l'équipe a été ajouté";
        }
    }
}
?>

<link rel="stylesheet" href="../styles.css">

<div class="container">
    <h2>Liste des équipes</h2>

    <div class="players-container">
        <?php foreach ($teams as $team) { ?>
            <div class="player-card">

                <div class="player-info">
                    <h3 class="player-name"><?= $team['name'] ?></h3>
                    <div class="player-actions">
                        <button class="btn-edit"><a href="modify_team.php?id=<?= $team['id'] ?>">Modifier</a></button>
                        <button class="btn-delete"><a href="delete_team.php?id=<?= $team['id'] ?>">Supprimer</a></button>
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