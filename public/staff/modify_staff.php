<?php
require_once '../../include/head2.php';

$id = $_GET['id'];

use App\Enum\EnumRolePlayer;
use App\Enum\EnumRoleStaff;
use App\Model\Error;
use App\Model\Form;
use App\Model\Staff;
use App\Controller\ControllerStaff;
use App\Controller\ControllerPlayerHasTeam;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerStaff();

$requete2 = new ControllerStaff();
$staff_member = $requete2->read($id);


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $requeteModify = new ControllerStaff();
        $requeteModify->modify($staff_member, $dataArray);
        header("Location: add_staff.php");
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">
    <h2 style="margin-top: 120px;">Modifier le membre du staff <?php echo $staff_member->getFirstname() . ' ' . $staff_member->getLastname() ?></h2>

    <form id="mainForm" method="post">
        <div>
            <label for="firstname">Prénom</label>
            <div class="input-wrap">
                <input id="firstname" name="firstname" type="text" placeholder="Ex. Chloé" aria-required="true" value="<?php echo $staff_member->getFirstName() ?>" />
            </div>
            <?php $data->getChamp('firstname'); ?>
        </div>

        <div>
            <label for="lastname">Nom</label>
            <div class="input-wrap">
                <input id="lastname" name="lastname" type="text" placeholder="Ex. Dupont" required aria-required="true" value="<?php echo $staff_member->getLastName() ?>" />
            </div>
            <?php $data->getChamp('lastname'); ?>
        </div>

        <label for="team">Rôle dans l'équipe</label>
        <div class="input-wrap">
            <input id="lastname" name="role" type="text" placeholder="Ex. Dupont" required aria-required="true" value="<?php echo $staff_member->getRole()->name ?>" />
        </div>



        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>