<?php

require_once '../head.php';

$id = $_GET['id'];

use App\Error;
use App\Form;
use App\Player;
use App\RequetesPlayer;


$requeteRead = new RequetesPlayer();
$player = $requeteRead->read($id);
$player = Player::arrayToPlayer($player);
$errors = new Error();
$data = new Form($_POST, $errors);


if ($_SERVER['REQUEST_METHOD'] === "POST") {


    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('birthdate');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $requeteModify = new RequetesPlayer();
        $requeteModify->modify($player, $dataArray);
        header("Location: add_player.php");
    }
}

?>
<link rel="stylesheet" href="../styles.css">

<div class="container">

    <h2>Modifier <?php echo $player->getFirstName() . ' ' . $player->getLastName() ?></h2>
    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Prénom</label>
            <div class="input-wrap">
                <input id="firstname" name="firstname" type="text" placeholder="Ex. Chloé" aria-required="true" value="<?php echo $player->getFirstName() ?>" />
            </div>
            <?php $data->getChamp('firstname'); ?>
        </div>

        <div>
            <label for="lastname">Nom</label>
            <div class="input-wrap">
                <input id="lastname" name="lastname" type="text" placeholder="Ex. Dupont" required aria-required="true" value="<?= $player->getLastName() ?>" />
            </div>
            <?php $data->getChamp('lastname'); ?>
        </div>

        <div>
            <label for="birthdate">Date de naissance</label>
            <div class="input-wrap">
                <input id="birthdate" name="birthdate" type="date" max="2100-12-31" value="<?= $player->getBirthdate() ?>" />
            </div>
            <?php
            $data->getChamp('birthdate');
            ?>
        </div>

        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>