<?php

namespace App\Model;


final class Form
{
    protected array $data;
    protected Error $errors;

    public function __construct(array $data, Error $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function getData()
    {
        return $this->data;
    }

    public function trimData(): array
    {
        return array_map('trim', $this->data);
    }

    public  function specialcharsData(): array
    {
        return array_map('htmlspecialchars', $this->data);
    }

    public function isEmpty(string $field): void
    {
        if (empty(trim($this->data[$field] ?? ''))) {
            $this->errors->addError($field, "Le champ $field est requis.");
        }
    }

    public function getChamp(string $field): void
    {
        foreach ($this->errors->getErrors($field) as $msg) {
            echo "<div style='color:red; text-transform:lowercase;'>$msg</div>";
        }
    }

    public function isEmailValid($champ)
    {
        if (!filter_var($this->getChamp($champ), FILTER_VALIDATE_EMAIL)) {
            $this->errors->addError($champ, "L'addresse mail renseignée n'est pas valide");
        }
    }
}
