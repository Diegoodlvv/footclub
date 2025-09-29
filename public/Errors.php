<?php

namespace public;

class Errors
{
    public string $errorString;

    public function __construct(string $errorString)
    {
        $this->errorString = $errorString;
    }

    public function afficherErreur()
    {
        if (isset($this->errorString)) {
            echo $this->errorString;
        } else {
            echo "";
        }
    }
}
