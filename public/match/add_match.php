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
use App\Model\Session;

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

    $data->isNegative('team_score');
    $data->isNegative('opponent_score');
    $data->isEmpty('date');
    $data->isEmpty('team');
    $data->isEmpty('opponent');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {

        $team = new Controllerteam()->read($dataArray['team']);
        $club = new ControllerOpposingClub()->read($dataArray['opponent']);

        $match = new Matchs($dataArray['team_score'], $dataArray['opponent_score'], $dataArray['date'], $team, $club->getCity(), $club);
        $requeteVerif = new ControllerMatch();

        $requeteMatch  = new ControllerMatch();
        $requeteMatch->add($match);

        Session::setMessage('match', true);
    }

    ControllerMatch::redirection();
    exit;
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <?php if (Session::hasMessage('match') && Session::getMessageType('match')) { ?>

        <?php Message::msgSuccesMatch() ?>

    <?php } else if (Session::hasMessage('match') && Session::getMessageType('match') == 'false') { ?>

        <?php Message::msgErrorMatch() ?>

    <?php } ?>

    <?php Session::clearMessage('match'); ?>

    <h2>Liste des matchs</h2>

    <div class="players-container">
        <?php foreach ($matchs as $match) { ?>
            <div class="player-card">
                <div class="player-info">
                    <h3 class="player-name" style="padding-bottom: 10px;"><?= $match->getTeam()->getTeamName() . ' vs ' . $match->getOpposing_club()->getName() ?></h3>
                    <p class="player-birthdate">Date du match : <?= $match->getDate() ?></p>
                    <p class="player-birthdate">Score du match : <?= $match->getTeamScore() . '-' . $match->getOpponentScore() ?></p>
                    <p class="player-birthdate">Lieu du match : <?= $match->getCity() . ' , ' . $match->getOpposing_club()->getAdress() ?></p>
                    <a href="delete_match.php?id=<?= $match->getId() ?>">
                        <button type="submit" class="btn btn-delete-small">Supprimer</button>
                    </a>
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
            <?php $data->getChamp('team_score'); ?>
        </div>

        <div>
            <label for="lastname">Score de l'équipe adverse</label>
            <div class="input-wrap">
                <input id="lastname" name="opponent_score" type="number" min="0" required aria-required="true" />
            </div>
            <?php $data->getChamp('opponent_score'); ?>
        </div>

        <div>
            <label for="birthdate">date du match</label>
            <div class="input-wrap">
                <input id="birthdate" name="date" type="date" max="2100-12-31" />
            </div>
            <?php
            $data->getChamp('date');
            ?>
        </div>

        <label for="team">Equipe</label>
        <select name="team" class="input-wrap" style="color:  white;">
            <?php foreach ($teams as $team) { ?>
                <option value="<?= $team->getId() ?>">
                    <?= $team->getTeamName() ?>
                </option>
            <?php } ?>
        </select>

        <label for="team">Equipe adverse</label>
        <select name="opponent" class="input-wrap" style="color:  white;">
            <?php foreach ($clubs as $club) { ?>
                <option value="<?= $club->getId() ?>">
                    <?= $club->getName() ?>
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