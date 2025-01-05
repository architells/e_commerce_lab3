<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAdmin(User $user)
    {
        return $user->roles->contains('role_name', 'Admin');
    }

    public function viewCustomer(User $user)
    {
        return $user->roles->contains('role_name', 'Customer');
    }
}
