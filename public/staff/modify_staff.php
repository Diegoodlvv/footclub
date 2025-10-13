<?php
require_once '../../head2.php';

$id = $_GET['id'];

use App\EnumRolePlayer;
use App\Error;
use App\Form;
use App\Staff;
use App\RequetesStaff;
use App\EnumRoleStaff;
use App\RequetesPlayerHasTeam;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new RequetesStaff();

$requete2 = new RequetesStaff();
$staff_member = $requete2->read($id);
$staff_member['role'] = EnumRoleStaff::from($staff_member['role']);
$staff_member = Staff::arrayToStaff($staff_member);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('role');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();

    if ($errors->isFormValid()) {
        $requeteModify = new RequetesStaff();
        $requeteModify->modify($staff_member, $dataArray);
        header("Location: add_staff.php");
    }
}
?>

<link rel="stylesheet" href="../styles.css">

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
        <select name="role" class="input-wrap" style="color:  white;">

            <option>
                <?= $staff_member->getRole()->name ?>
            </option>

        </select>


        <div class="full">
            <div class="actions">
                <input type="submit" class="btn" id="submitBtn">
            </div>
        </div>
    </form>
</div>