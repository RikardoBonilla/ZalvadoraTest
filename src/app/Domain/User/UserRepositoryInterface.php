<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function countByCompanyId(int $companyId): int;
    public function delete(int $id): bool;
}