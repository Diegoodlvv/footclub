<?php
require_once '../../include/head2.php';


use App\Model\Error;
use App\Model\Form;
use App\Controller\ControllerMatch;
use App\Controller\Controllerteam;
use App\Controller\ControllerOpposingClub;
use App\Model\Team;
use App\Model\Matchs;
use App\Model\Message;
use App\Model\OpposingClub;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerMatch();


$requeteTeams = new ControllerTeam();
$teams = $requeteTeams->readAll();

$requetesClubs = new ControllerOpposingClub();
$clubs = $requetesClubs->readAll();

$requeteMatch = new ControllerMatch();
$matchs = $requeteMatch->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('team_score');
    $data->isEmpty('opponent_score');
    $data->isEmpty('date');
    $data->isEmpty('team');
    $data->isEmpty('opponent');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {

        $match = new Matchs($dataArray['team_score'], $dataArray['opponent_score'], $dataArray['date'],);
        $requeteVerif = new ControllerMatch();

        $requeteTeam = new ControllerTeam();
        $team = $requeteTeam->read($dataArray['team']);
        if ($requeteVerif->verifExistancePlayer($player)) {

            $_SESSION['message_player'] = 'false';
        } else {
            $playerId = $requete->add($player);
            $requetePlayerHasTeam = new ControllerPlayerHasTeam();
            $playerTeam = [
                "team_id" => $team['id'],
                "player_id" => $playerId,
                "role" => $dataArray['role']
            ];
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

    <h2>Liste des matchs</h2>

    <div class="players-container">
        <?php foreach ($matchs as $match) {

            $requete = new Controllerteam();
            $team = $requete->read($match['id']);

            $requete2 = new ControllerOpposingClub();
            $opposing_club = $requete->read($match['id']);

        ?>
            <div class="player-card">
                <div class="player-info">
                    <h3 class="player-name"><?= $team . ' Contre ' . $opposing_club ?></h3>
                    <p class="player-birthdate">Date du match : <?= $match['date'] ?></p>
                    <p class="player-birthdate">Lieu du match : <?= $match['city'] . ' , ' . $match['address'] ?></p>
                    <div class="player-actions">
                        <button class="btn-edit"><a href="modify_match.php?id=<?= $match['id'] ?>">Modifier</a></button>
                        <button class="btn-delete"><a href="delete_match.php?id=<?= $match['id'] ?>">Supprimer</a></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h2 style="margin-top: 120px;">Ajouter un nouveau Match</h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Score de l'équipe 1</label>
            <div class="input-wrap">
                <input id="firstname" name="team_score" type="number" min="0" aria-required="true" />
            </div>
            <?php $data->getChamp('firstname'); ?>
        </div>

        <div>
            <label for="lastname">Score de l'équipe adverse</label>
            <div class="input-wrap">
                <input id="lastname" name="opponent_score" type="number" min="0" required aria-required="true" />
            </div>
            <?php $data->getChamp('lastname'); ?>
        </div>

        <div>
            <label for="birthdate">date du match</label>
            <div class="input-wrap">
                <input id="birthdate" name="date" type="date" max="2100-12-31" />
            </div>
            <?php
            $data->getChamp('birthdate');
            ?>
        </div>

        <label for="team">Equipe</label>
        <select name="team" class="input-wrap" style="color:  white;">
            <?php foreach ($teams as $team) {
                var_dump($team); ?>
                <option value="<?= $team['id'] ?>">
                    <?= $team ?>
                </option>
            <?php } ?>
        </select>

        <label for="team">Equipe adverse</label>
        <select name="opponent" class="input-wrap" style="color:  white;">
            <?php foreach ($clubs as $club) { ?>
                <option value="<?= $club['id'] ?> ">
                    <?= $club['name'] ?>
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