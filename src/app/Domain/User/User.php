<?php

namespace App\Domain\User;

class User
{
    public function __construct(
        public ?int $id,
        public int $companyId,
        public string $name,
        public string $email,
        public string $password // Guardaremos el hash, no el texto plano
    ) {}
}