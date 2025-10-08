<?php
require_once '../head2.php';


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
$staff_members = $requete2->readAll();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data->isEmpty('firstname');
    $data->isEmpty('lastname');
    $data->isEmpty('picture');
    $data->isEmpty('role');

    $data->trimData();
    $data->specialcharsData();

    $dataArray = $data->getData();
    var_dump(EnumRoleStaff::tryFrom($dataArray['role']));
    if ($errors->isFormValid()) {
        $staff_member = new Staff($dataArray['firstname'], $dataArray['lastname'], $dataArray['picture'], EnumRoleStaff::tryFrom($dataArray['role']));
        $requeteStaff = new RequetesStaff();
        if ($requeteStaff->verifyExistanceStaff($staff_member)) {
            echo 'Ce membre du staff a déjà été renseigné';
        } else {
            $requete->add($staff_member);
            echo 'Ce nouveau membre du staff a bien été ajouté';
        }
    }
}
?>

<link rel="stylesheet" href="../styles.css">

<div class="container">
    <h2>Liste des membres du staff</h2>

    <div class="players-container">
        <?php foreach ($staff_members as $staff_member) { ?>
            <div class="player-card">
                <img src="uploads/<?php echo $staff_member['picture'] ?>" alt="Photo du joueur" class="player-photo">
                <div class="player-info">
                    <h3 class="player-name"><?= $staff_member['firstname'] . ' ' . $staff_member['lastname'] ?></h3>
                    <p class="player-birthdate">Rôle du staff : <?= $staff_member['role'] ?></p>
                    <div class="player-actions">
                        <button class="btn-edit"><a href="modify_player.php?id=<?= $staff_member['id'] ?>">Modifier</a></button>
                        <button class="btn-delete"><a href="delete_player.php?id=<?= $staff_member['id'] ?>">Supprimer</a></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

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
                <option value="<?= $role->value ?> ">
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