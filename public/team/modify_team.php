<?php
require_once '../../include/head2.php';


use App\Model\Error;
use App\Model\Form;
use App\Model\Team;
use App\Controller\ControllerTeam;

$id = $_GET['id'];

$requeteRead = new ControllerTeam();
$team = $requeteRead->read($id);
$team = Team::arrayToTeam($team);
$errors = new Error();
$data = new Form($_POST, $errors);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('name');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $requeteModify = new ControllerTeam();
        $requeteModify->modify($team, $dataArray);
        header("Location: add_team.php");
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <h2 style="margin-top: 120px;">Modifier l'équipe <?php echo  $team->GetTeamName() ?></h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Nom de l'équipe</label>
            <div class="input-wrap">
                <input id="firstname" name="name" type="text" value="<?= $team->GetTeamName() ?>" aria-required="true" />
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