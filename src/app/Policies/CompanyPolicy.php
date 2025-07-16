<?php

namespace App\Policies;

use App\Models\User;

class CompanyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
     
    /**
     * Determine whether the user can add a user to the company.
     */
    public function addUser(UserModel $user, CompanyModel $company): bool
    {
        // Solo permite la acción si el ID de la empresa del usuario autenticado
        // es el mismo que el de la empresa a la que se quiere añadir el nuevo usuario.
        return $user->company_id === $company->id;
    }
}
