<?php

namespace App\Application\Company\Update;

class UpdateCompanyDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name // Por ahora solo actualizaremos el nombre
    ) {}
}