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
use App\Model\PlayerHasTeam;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerPlayer();

$requete2 = new ControllerPlayer();
$players = $requete2->readAll();

$requeteTeams = new ControllerTeam();
$teams = $requeteTeams->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // 🟩 Formulaire d'ajout d'un joueur dans une équipe
    if (isset($_POST['Role']) && isset($_POST['Team']) && isset($_POST['player_id'])) {
        $data->isEmpty('Role');
        $data->isEmpty('Team');

        $data->trimData();
        $data->specialcharsData();
        $dataArray = $data->getData();

        if ($errors->isFormValid()) {
            $playerId = $_POST['player_id'];
            $teamId = $dataArray['Team'];
            $role = EnumRolePlayer::from($dataArray['Role']);

            $player = (new ControllerPlayer())->read($playerId);
            $team = (new ControllerTeam())->read($teamId);

            if ($player && $team) {
                $playerHasTeam = new PlayerHasTeam($team, $player, $role);

                if (new ControllerPlayerHasTeam()->verifyPlayerTeamRole($playerHasTeam) == true) {

                    $controllerPHT = new ControllerPlayerHasTeam();
                    $controllerPHT->add($playerHasTeam);

                    $_SESSION['message_playerTeam'] = 'true';
                } else {

                    $_SESSION['message_playerTeam'] = 'false';
                }
            } else {
                echo "L'équipe ou le joueur n'éxiste pas";
            }

            header("Location: add_player.php");
            exit;
        }
    }

    //  Formulaire de création d’un joueur

    elseif (isset($_POST['firstname'])) {
        $data->isEmpty('firstname');
        $data->isEmpty('lastname');
        $data->isEmpty('birthdate');
        $data->isEmpty('picture');

        $data->trimData();
        $data->specialcharsData();
        $dataArray = $data->getData();

        if ($errors->isFormValid()) {
            $player = new Player(
                $dataArray['firstname'],
                $dataArray['lastname'],
                $dataArray['birthdate'],
                $dataArray['picture']
            );

            $controllerPlayer = new ControllerPlayer();
            if ($controllerPlayer->verifExistancePlayer($player)) {
                $_SESSION['message_player'] = 'false';
            } else {
                $controllerPlayer->add($player);
                $_SESSION['message_player'] = 'true';
            }

            header("Location: add_player.php");
            exit;
        }
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
    <?php } else if (isset($_SESSION['message_playerTeam']) && $_SESSION['message_playerTeam'] == 'false') { ?>
        <div class="error-message">
            <?php Message::msgErrorPlayerTeam() ?>
        </div>
    <?php } else if (isset($_SESSION['message_playerTeam']) && $_SESSION['message_playerTeam'] == 'true') { ?>
        <div class="success-message">
            <?php Message::msgSuccesPlayerTeam() ?>
        </div>
    <?php }
    unset($_SESSION['message_player'], $_SESSION['message_playerTeam']) ?>

    <h2>Liste des joueurs</h2>

    <div class="players-grid">
        <?php foreach ($players as $player) { ?>
            <div class="player-card-modern">
                <div class="player-header">
                    <img src="../../img/<?= ($player->getPicture()) ?>" alt="Photo du joueur" class="player-img">
                    <div class="player-basic-info">
                        <h3><?= ($player->getFirstName() . ' ' . $player->getLastName()) ?></h3>
                        <p class="player-date">Né(e) le <?= ($player->getBirthdate()) ?></p>
                    </div>
                </div>

                <div class="player-teams">
                    <h4>Clubs & postes</h4>
                    <?php
                    $requete = new ControllerPlayerHasTeam();
                    $playersHasTeams = $requete->getTeams($player);
                    if (!empty($playersHasTeams)) { ?>
                        <ul class="player-team-list">
                            <?php foreach ($playersHasTeams as $playerHasTeam) { ?>
                                <li class="player-team-item">
                                    <span class="team-name"><?= ($playerHasTeam->getTeam()->getTeamName()) ?></span>
                                    <span class="team-role">— <?= ($playerHasTeam->getRole()->name) ?></span>
                                    <a href="delete_player_team.php?playerId=<?= $playerHasTeam->getPlayer()->getId() ?>,teamId=<?= $playerHasTeam->getTeam()->getId() ?>">
                                        <button type="submit" class="btn btn-delete-small">✕</button>
                                    </a>
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

                <form method="post" class="add-team-form">
                    <input type="hidden" name="player_id" value="<?= (int)$player->getId() ?>">

                    <label>Équipe</label>
                    <select name="Team">
                        <?php foreach ($teams as $team) { ?>
                            <option value="<?= (int)$team->getId() ?>"><?= ($team->getTeamName()) ?></option>
                        <?php } ?>
                    </select>

                    <label>Poste</label>
                    <select name="Role">
                        <?php foreach (EnumRolePlayer::cases() as $role) { ?>
                            <option value="<?= $role->value ?>"><?= $role->name ?></option>
                        <?php } ?>
                    </select>

                    <input type="submit" class="btn btn-add" value="Ajouter">
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

        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>