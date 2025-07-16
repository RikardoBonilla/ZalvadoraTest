<?php

namespace App\Domain\Company;

class Company
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email, // Email de contacto de la empresa
        // Podríamos añadir más campos como teléfono, dirección, etc.
    ) {}
}