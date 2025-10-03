<?php
require_once '../head.php';


use App\Error;
use App\Form;
use App\Player;
use App\RequetesPlayer;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new RequetesPlayer();

$requete2 = new RequetesPlayer();
$players = $requete2->readAll();
var_dump($players);

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

    <h2 style="margin-top: 120px;">Ajouter un nouveau joueur</h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Prénom</label>
            <div class="input-wrap">
                <input id="firstname" name="firstname" type="text" placeholder="Ex. Chloé" aria-required="true" />
            </div>
            <?php $data->getChamp('firstname'); ?>
        </div>

        <div>
            <label for="lastname">Nom</label>
            <div class="input-wrap">
                <input id="lastname" name="lastname" type="text" placeholder="Ex. Dupont" required aria-required="true" />
            </div>
            <?php $data->getChamp('lastname'); ?>
        </div>

        <div>
            <label for="birthdate">Date de naissance</label>
            <div class="input-wrap">
                <input id="birthdate" name="birthdate" type="date" max="2100-12-31" />
            </div>
            <?php
            $data->getChamp('birthdate');
            ?>
        </div>

        <div> <label for="picture">Photo</label>
            <div class="input-wrap"> <label class="file-drop" for="picture" id="dropZone" tabindex="0" aria-describedby="pictureHint"> <img src="" alt="aperçu" id="previewImg" class="preview" style="display:none" />
                    <div id="dropText"> <strong>Glisser / déposer</strong>
                        <div class="muted">ou cliquer pour sélectionner un fichier (jpg/png)</div>
                    </div> <input id="picture" name="picture" type="file" accept="image/*" />
                </label>
                <div id="pictureHint" class="hint">Taille max recommandée : 5 MB — carré de préférence.</div>
            </div> <?php $data->getChamp('picture'); ?>
        </div>

        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>