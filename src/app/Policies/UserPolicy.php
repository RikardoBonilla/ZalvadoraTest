<?php

namespace App\Policies;

use App\Models\Infrastructure\Persistence\Eloquent\Models\UserModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $user, UserModel $model): bool
    {
        // Un usuario solo puede actualizar a otro si ambos pertenecen a la misma empresa.
        return $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserModel $user, UserModel $model): bool
    {
        // La misma regla para borrar.
        return $user->company_id === $model->company_id;
    }
}
