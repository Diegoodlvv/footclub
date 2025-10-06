<?php
require_once '../head.php';


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

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('birthdate');
    $data->isEmpty('picture');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    var_dump($dataArray);

    if ($errors->isFormValid()) {
        $player = new Player($dataArray['firstname'], $dataArray['lastname'], $dataArray['birthdate'], $dataArray['picture']);
        $requeteVerif = new RequetesPlayer();
        if ($requeteVerif->verifExistancePlayer($player)) {
            echo 'Le joueur a déjà été ajouté auparavant';
        } else {
            $requete->add($player);
            echo 'Le joueur a été ajouté';
        }
    }
}
?>

<link rel="stylesheet" href="../styles.css">

<div class="container">
    <h2>Liste des joueurs</h2>

    <div class="players-container">
        <?php foreach ($players as $player) { ?>
            <div class="player-card">
                <img src="uploads/<?php echo $player['picture'] ?>" alt="Photo du joueur" class="player-photo">
                <div class="player-info">
                    <h3 class="player-name"><?= $player['firstname'] . ' ' . $player['lastname'] ?></h3>
                    <p class="player-birthdate">Née le : <?= $player['birthdate'] ?></p>
                    <div class="player-actions">
                        <button class="btn-edit"><a href="modify_player.php?id=<?= $player['id'] ?>">Modifier</a></button>
                        <button class="btn-delete"><a href="delete_player.php?id=<?= $player['id'] ?>">Supprimer</a></button>
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
            <?php $data->getChamp('firstname'); ?>
        </div>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>