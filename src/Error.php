<?php

namespace App;

class Error
{
    protected array $errors;

    public function addError($champ, $message)
    {
        echo $this->errors[$champ] = $message;
    }

    public function isFormValid()
    {
        return empty($this->errors);
    }
}
