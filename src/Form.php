<?php

namespace App;

use DateTime;

class Form
{
    protected array $data = [];
    protected Error $erreur;

    public function __construct(array $data, Error $erreur)
    {
        $this->data = $data;
        $this->erreur = $erreur;
    }


    public function trimData(): array
    {
        return array_map('trim', $this->data);
    }

    public  function specialcharsData(): array
    {
        return array_map('htmlspecialchars', $this->data);
    }

    public function getChamp($champ)
    {
        $this->trimData();
        $this->specialcharsData();
        return $this->data[$champ];
    }

    public function isEmpty($champ)
    {
        if (empty($this->getChamp($champ))) {
            $this->erreur->addError($champ, "Le champ $champ doit être renseigné");
        }
    }

    public function isEmailValid($champ)
    {
        if (!filter_var($this->getChamp($champ), FILTER_VALIDATE_EMAIL)) {
            $this->erreur->addError($champ, "L'addresse mail renseignée n'est pas valide");
        }
    }

    public function isDateValid($champ)
    {
        if (!($this->getChamp($champ) instanceof DateTime)) {
        }
    }
}
