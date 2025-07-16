<?php

namespace App\Application\User\Add;

class AddUserToCompanyDTO
{
    public function __construct(
        public readonly int $companyId,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {}
}