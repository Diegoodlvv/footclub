<?php
require_once '../../include/head2.php';

use App\Model\Error;
use App\Model\Form;
use App\Model\Staff;
use App\Controller\ControllerStaff;
use App\Enum\EnumRoleStaff;
use App\Model\Message;

$errors = new Error();
$data = new Form($_POST ?? [], $errors);
$requete = new ControllerStaff();

$requete2 = new ControllerStaff();
$staff_members = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('picture');
    $data->isEmpty('role');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();
    $role = EnumRoleStaff::from($dataArray['role']);
    if ($errors->isFormValid()) {
        $staff_member = new Staff($dataArray['firstname'], $dataArray['lastname'], $dataArray['picture'], $role);
        $requeteStaff = new ControllerStaff();
        if ($requeteStaff->verifyExistanceStaff($staff_member)) {
            $_SESSION['message_staff'] = 'false';
        } else {
            $requete->add($staff_member);
            $_SESSION['message_staff'] = 'true';
        }
        header('Location: add_staff.php');
    }
}
?>

<link rel="stylesheet" href="../../include/styles.css">

<div class="container">
    <?php if (isset($_SESSION['message_staff']) && $_SESSION['message_staff'] == 'true') { ?>
        <div class="success-message">
            <?php Message::msgSuccesStaff() ?>
        </div>
    <?php } else if (isset($_SESSION['message_staff']) && $_SESSION['message_staff']  == 'false') { ?>
        <div class="error-message">
            <?php Message::msgErrorStaff() ?>
            <?php unset($_SESSION['message_staff']) ?>
        </div>
    <?php } ?>

    <h2>Liste des membres du staff</h2>

    <?php if (!empty($staff_members)) { ?>
        <div class="players-container">
            <?php foreach ($staff_members as $staff_member) { ?>
                <div class="player-card">
                    <img src="../../img/<?= htmlspecialchars($staff_member->getPicture()) ?>" alt="Photo du joueur" class="player-photo">
                    <div class="player-info">
                        <h3 class="player-name">
                            <?= htmlspecialchars($staff_member->getFirstName() . ' ' . $staff_member->getLastName()) ?>
                        </h3>
                        <p class="player-birthdate">
                            Rôle du staff : <?= htmlspecialchars($staff_member->getRole()->name) ?>
                        </p>
                        <div class="player-actions">
                            <button class="btn-edit">
                                <a href="modify_staff.php?id=<?= (int)$staff_member->getId() ?>">Modifier</a>
                            </button>
                            <button class="btn-delete">
                                <a href="delete_staff.php?id=<?= (int)$staff_member->getId() ?>">Supprimer</a>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Aucun membre du staff n'a été renseigné.</p>
    <?php } ?>


    <h2 style="margin-top: 120px;">Ajouter un nouveau membre au staff</h2>

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

        <div> <label for="picture">Photo</label>
            <div class="input-wrap"> <label class="file-drop" for="picture" id="dropZone" tabindex="0" aria-describedby="pictureHint"> <img src="" alt="aperçu" id="previewImg" class="preview" style="display:none" />
                    <div id="dropText"> <strong>Glisser / déposer</strong>
                        <div class="muted">ou cliquer pour sélectionner un fichier (jpg/png)</div>
                    </div> <input id="picture" name="picture" type="file" accept="image/*" />
                </label>
                <div id="pictureHint" class="hint">Taille max recommandée : 5 MB — carré de préférence.</div>
            </div> <?php $data->getChamp('picture'); ?>
        </div>

        <label for="team">Rôle dans l'équipe</label>
        <select name="role" class="input-wrap" style="color:  white;">
            <?php foreach (EnumRoleStaff::cases() as $role) { ?>
                <option value="<?= $role->value ?>">
                    <?= $role->name ?>
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