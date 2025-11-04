<?php
require_once '../../include/head2.php';


use App\Model\Error;
use App\Model\Form;
use App\Model\Player;
use App\Controller\ControllerPlayer;
use App\Controller\ControllerTeam;
use App\Enum\EnumRolePlayer;
use App\Controller\ControllerPlayerHasTeam;
use App\Model\Message;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerPlayer();

$requete2 = new ControllerPlayer();
$players = $requete2->readAll();

$requeteTeams = new ControllerTeam();
$teams = $requeteTeams->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('birthdate');
    $data->isEmpty('picture');
    $data->isEmpty('team');
    $data->isEmpty('role');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $player = new Player($dataArray['firstname'], $dataArray['lastname'], $dataArray['birthdate'], $dataArray['picture']);
        $requeteVerif = new ControllerPlayer();

        if ($requeteVerif->verifExistancePlayer($player)) {

            $_SESSION['message_player'] = 'false';
        } else {
            $playerId = $requete->add($player);
            $requetePlayerHasTeam = new ControllerPlayerHasTeam();
            $requetePlayerHasTeam->add($playerTeam);

            $_SESSION['message_player'] = 'true';
        }
        header("Location: add_player.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <?php if (isset($_SESSION['message_player']) && $_SESSION['message_player'] == 'true') { ?>
        <div class="success-message">
            <?php Message::msgSuccesPlayer() ?>
        </div>
    <?php } else if (isset($_SESSION['message_player']) && $_SESSION['message_player']  == 'false') { ?>
        <div class="error-message">
            <?php Message::msgErrorPlayer() ?>
        </div>
    <?php } ?>
    <?php unset($_SESSION['message_player']) ?>

    <h2>Liste des joueurs</h2>

    <div class="players-grid">
        <?php foreach ($players as $player) { ?>
            <div class="player-card-modern">
                <div class="player-header">
                    <img src="../../img/<?= htmlspecialchars($player->getPicture()) ?>" alt="Photo du joueur" class="player-img">
                    <div class="player-basic-info">
                        <h3><?= htmlspecialchars($player->getFirstName() . ' ' . $player->getLastName()) ?></h3>
                        <p class="player-date">Né(e) le <?= htmlspecialchars($player->getBirthdate()) ?></p>
                    </div>
                </div>

                <div class="player-teams">
                    <h4>Clubs & postes</h4>
                    <?php
                    $requete = new ControllerPlayerHasTeam();
                    $playersHasTeams = $requete->getTeams($player);
                    if (!empty($playersHasTeams)) { ?>
                        <ul>
                            <?php foreach ($playersHasTeams as $playerHasTeam) { ?>
                                <li>
                                    <span class="team-name"><?= htmlspecialchars($playerHasTeam->getTeam()->getTeamName()) ?></span>
                                    <span class="team-role">— <?= htmlspecialchars($playerHasTeam->getRole()->name) ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="no-team">Aucun club renseigné</p>
                    <?php } ?>
                </div>

                <div class="player-actions">
                    <a href="modify_player.php?id=<?= (int)$player->getId() ?>" class="btn btn-edit">Modifier</a>
                    <a href="delete_player.php?id=<?= (int)$player->getId() ?>" class="btn btn-delete">Supprimer</a>
                </div>

                <form method="post" action="add_player_to_team.php" class="add-team-form">
                    <input type="hidden" name="player_id" value="<?= (int)$player->getId() ?>">

                    <label>Équipe</label>
                    <select name="team_id">
                        <?php foreach ($teams as $team) { ?>
                            <option value="<?= (int)$team->getId() ?>"><?= htmlspecialchars($team->getTeamName()) ?></option>
                        <?php } ?>
                    </select>

                    <label>Poste</label>
                    <select name="role">
                        <?php foreach (EnumRolePlayer::cases() as $role) { ?>
                            <option value="<?= $role->value ?>"><?= $role->name ?></option>
                        <?php } ?>
                    </select>

                    <button type="submit" class="btn btn-add">Ajouter</button>
                </form>
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

        <label for="team">Equipe</label>
        <select name="team" class="input-wrap" style="color:  white;">
            <?php foreach ($teams as $team) { ?>
                <option value="<?= $team->getTeamName() ?>">
                    <?= $team->getTeamName() ?>
                </option>
            <?php } ?>
        </select>

        <label for="team">Rôle dans l'équipe</label>
        <select name="role" class="input-wrap" style="color:  white;">
            <?php foreach (EnumRolePlayer::cases() as $role) { ?>
                <option value="<?= $role->value ?> ">
                    <?= $role->name ?>
                </option>
            <?php } ?>
        </select>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>