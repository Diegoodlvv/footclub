<?php

namespace App\Model;

final class Error
{
    protected array $errors = [];

    public function addError(string $champ, string $message): void
    {
        $this->errors[$champ][] = $message;
    }

    public function getErrors(string $champ): array
    {
        return $this->errors[$champ] ?? [];
    }

    public function all(): array
    {
        return $this->errors;
    }

    public function isFormValid(): bool
    {
        return empty($this->errors);
    }
}
