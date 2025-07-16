<?php

namespace App\Domain\Company;

use DateTime;

class Subscription
{
    public function __construct(
        public ?int $id,
        public int $companyId,
        public int $planId,
        public DateTime $startDate,
        public ?DateTime $endDate // Será null si la suscripción está activa
    ) {}
}