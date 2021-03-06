<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function editProfile(User $authUser, User $user)
    {
        return $authUser->is($user);
    }

    public function isAdmin(User $user)
    {
        return $user->role_id === UserRole::USER_ADMIN;
    }
}
