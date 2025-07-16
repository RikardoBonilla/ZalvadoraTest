<?php

namespace App\Domain\Plan;

class Plan
{
    public function __construct(
        public ?int $id,
        public string $name,
        public float $price,
        public int $userLimit,
        public array $features
    ) {}
}