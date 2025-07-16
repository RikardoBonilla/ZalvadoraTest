<?php

namespace App\Application\Plan\Create;

class CreatePlanDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly int $userLimit,
        public readonly array $features
    ) {}
}