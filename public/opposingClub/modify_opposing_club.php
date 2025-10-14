<?php
require_once '../../include/head2.php';

$id = $_GET['id'];

use App\Model\Error;
use App\Model\Form;
use App\Model\OpposingClub;
use App\Controller\ControllerOpposingClub;
use App\Model\Message;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerOpposingClub();
$opposing_club = $requete->read($id);

$requete2 = new ControllerOpposingClub();
$opposing_clubs = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('name');
    $data->isEmpty('address');
    $data->isEmpty('city');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $opposing_club = new OpposingClub($dataArray['name'], $dataArray['address'], $dataArray['city']);
        $requeteVerif = new ControllerOpposingClub();
        if ($requeteVerif->verifyOpposingClub($opposing_club)) {
            $requete->add($opposing_club);
            $_SESSION['message_club'] = "true";
        } else {
            $_SESSION['message_club'] = 'false';
        }
        header("Location: add_opposing_club.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">

    <?php if (isset($_SESSION['message_club']) && $_SESSION['message_club'] == 'true') { ?>
        <div class="success-message">
            <?php Message::msgSuccesClub() ?>
        </div>
    <?php } else if (isset($_SESSION['message_club']) && $_SESSION['message_club']  == 'false') { ?>
        <div class="error-message">
            <?php Message::msgErrorClub() ?>
        </div>
    <?php } ?>
    <?php unset($_SESSION['message_club']) ?>

    <h2 style="margin-top: 120px;">Modifier l'équipe adverse <?php echo $opposing_club['name'] ?></h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Nom de l'équipe</label>
            <div class="input-wrap">
                <input id="firstname" name="name" type="text" placeholder="Ex. PSG" aria-required="true" value="<?= $opposing_club['name'] ?>" />
            </div>
            <?php $data->getChamp('name'); ?>
        </div>

        <div>
            <label for="address">Adresse de l'équipe</label>
            <div class="input-wrap">
                <input id="address" name="address" type="text" placeholder="Ex. parc des princes" aria-required="true" value="<?= $opposing_club['address'] ?>" />
            </div>
            <?php $data->getChamp('address'); ?>
        </div>

        <div>
            <label for="city">Ville de l'équipe</label>
            <div class="input-wrap">
                <input id="city" name="city" type="text" placeholder="Ex. Paris" aria-required="true" value="<?= $opposing_club['city'] ?>" />
            </div>
            <?php $data->getChamp('city'); ?>
        </div>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>