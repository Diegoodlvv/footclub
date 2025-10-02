<?php

require_once '../head.php';

use App\Form;
use App\Error;

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = new Error();
    $data = new Form($_POST, $errors);
    var_dump($data);
}

?>

<link rel="stylesheet" href="../styles.css">



<div class="container">


    <h2>Liste des joueurs</h2>


    <form id="mainForm" novalidate>
        <div>
            <label for="firstname">Prénom</label>
            <div class="input-wrap">
                <input id="firstname" name="firstname" type="text" placeholder="Ex. Chloé" required aria-required="true" />
            </div>
        </div>


        <div>
            <label for="lastname">Nom</label>
            <div class="input-wrap">
                <input id="lastname" name="lastname" type="text" placeholder="Ex. Dupont" required aria-required="true" />
            </div>
        </div>


        <div>
            <label for="birthdate">Date de naissance</label>
            <div class="input-wrap">
                <input id="birthdate" name="birthdate" type="date" max="2100-12-31" />
            </div>
        </div>


        <div>
            <label for="picture">Photo</label>
            <div class="input-wrap">
                <label class="file-drop" for="picture" id="dropZone" tabindex="0" aria-describedby="pictureHint">
                    <img src="" alt="aperçu" id="previewImg" class="preview" style="display:none" />
                    <div id="dropText">
                        <strong>Glisser / déposer</strong>
                        <div class="muted">ou cliquer pour sélectionner un fichier (jpg/png)</div>
                    </div>
                    <input id="picture" name="picture" type="file" accept="image/*" />
                </label>
                <div id="pictureHint" class="hint">Taille max recommandée : 5 MB — carré de préférence.</div>
            </div>
        </div>


        <div class="full">
            <div class="actions">
                <button type="reset" class="btn" id="resetBtn">Réinitialiser</button>
                <button type="submit" class="btn" id="submitBtn">Envoyer</button>
            </div>
        </div>


    </form>
</div>