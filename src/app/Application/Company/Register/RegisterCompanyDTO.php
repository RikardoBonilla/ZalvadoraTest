<?php

namespace App\Application\Company\Register;

class RegisterCompanyDTO
{
    public function __construct(
        public readonly string $companyName,
        public readonly string $companyEmail,
        public readonly int $planId
    ) {}
}