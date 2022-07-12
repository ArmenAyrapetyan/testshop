<?php

namespace App\Services;

use App\Models\ProductType;
use App\Models\User;

class UserPolicyService
{
    public static function canCreate()
    {
        if (auth()->user()->cannot('create', ProductType::class))
            return true;
        return false;
    }

    public static function canEditProfile(User $user)
    {
        if (auth()->user()->cannot('editProfile', $user))
            return true;
        return false;
    }

    public static function isAdminUser()
    {
        if (auth()->user()->cannot('isAdmin', User::class))
            return true;
        return false;
    }

    public static function toProfile($isAPI = false)
    {
        if ($isAPI){
            return [
                'message' => 'Доступ закрыт'
            ];
        }
        return redirect()->route('profile')->withErrors(['error' => 'Доступ закрыт']);
    }
}
