<?php

namespace App\Application\Plan\Update;

class UpdatePlanDTO
{
    public function __construct(
        public readonly int $id, 
        public readonly string $name,
        public readonly float $price,
        public readonly int $userLimit,
        public readonly array $features
    ) {}
}