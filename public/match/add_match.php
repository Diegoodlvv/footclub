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

    $data->isNegative('team_score');
    $data->isNegative('opponent_score');
    $data->isEmpty('date');
    $data->isEmpty('team');
    $data->isEmpty('opponent');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {

        $requete1 = new Controllerteam();
        $requete1->readTeamID($dataArray['team']);

        $requete2 = new ControllerOpposingClub();
        $requete2->readClubId($dataArray['opponent']);


        $selectedTeam = null;
        foreach ($teams as $team) {
            if ($team['object']->getTeamName() === $dataArray['team']) {
                $selectedTeam = $team;
            }
        }

        $selectedOpponent = null;
        foreach ($clubs as $club) {

            if ($club['object']->getName() === $dataArray['opponent']) {
                $selectedOpponent = $club;
                break;
            }
        }

        $match = new Matchs($dataArray['team_score'], $dataArray['opponent_score'], $dataArray['date'], $selectedTeam['object'], $selectedOpponent['object']->getCity(), $selectedOpponent['object']);
        $requeteVerif = new ControllerMatch();

        $requeteMatch  = new ControllerMatch();
        $requeteMatch->add($match);
        $_SESSION['message_match'] = 'true';
        header("Location: add_match.php");
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <?php if (isset($_SESSION['message_match']) && $_SESSION['message_match'] == 'true') { ?>
        <div class="success-message">
            <?php Message::msgSuccesMatch() ?>
        </div>
    <?php } else if (isset($_SESSION['message_match']) && $_SESSION['message_match']  == 'false') { ?>
        <div class="error-message">
            <?php Message::msgErrorMatch() ?>
        </div>
    <?php } ?>
    <?php unset($_SESSION['message_match']) ?>

    <h2>Liste des matchs</h2>

    <div class="players-container">
        <?php foreach ($matchs as $match) {

            $requete = new Controllerteam();
            $team = $requete->read($match['team_id']);

            $requete2 = new ControllerOpposingClub();
            $opposing_club = $requete2->read($match['opposing_club_id']);

        ?>
            <div class="player-card">
                <div class="player-info">
                    <h3 class="player-name" style="padding-bottom: 10px;"><?= $team['name'] . ' vs ' . $opposing_club['name'] ?></h3>
                    <p class="player-birthdate">Date du match : <?= $match['date'] ?></p>
                    <p class="player-birthdate">Score du match : <?= $match['team_score'] . '-' . $match['opponent_score'] ?></p>
                    <p class="player-birthdate">Lieu du match : <?= $match['city'] . ' , ' . $opposing_club['address'] ?></p>
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
                <option value="<?= $team['object']->getTeamName() ?>">
                    <?= $team['object']->getTeamName() ?>
                </option>
            <?php } ?>
        </select>

        <label for="team">Equipe adverse</label>
        <select name="opponent" class="input-wrap" style="color:  white;">
            <?php foreach ($clubs as $club) { ?>
                <option value="<?= $club['object']->getName() ?>">
                    <?= $club['object']->getName() ?>
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