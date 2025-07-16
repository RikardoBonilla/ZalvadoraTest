<?php

namespace App\Application\Company\ChangePlan;

class ChangeCompanyPlanDTO
{
    public function __construct(
        public readonly int $companyId,
        public readonly int $newPlanId
    ) {}
}