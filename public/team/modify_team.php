<?php
require_once '../head2.php';


use App\Error;
use App\Form;
use App\Team;
use App\RequetesTeam;

$id = $_GET['id'];

$requeteRead = new RequetesTeam();
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
        $requeteModify = new RequetesTeam();
        $requeteModify->modify($team, $dataArray);
        header("Location: add_team.php");
    }
}
?>

<link rel="stylesheet" href="../styles.css">

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