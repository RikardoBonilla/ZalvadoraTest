<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $userModel = UserModel::updateOrCreate(
            ['id' => $user->id],
            [
                'company_id' => $user->companyId,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
            ]
        );
        $user->id = $userModel->id;
        return $user;
    }

    public function findById(int $id): ?User
    {
        // ... (implementación similar a los otros repositorios)
    }

    public function findByEmail(string $email): ?User
    {
        // ... (implementación similar a los otros repositorios)
    }

    public function countByCompanyId(int $companyId): int
    {
        return UserModel::where('company_id', $companyId)->count();
    }
}