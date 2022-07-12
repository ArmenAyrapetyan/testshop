<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use App\Services\UserPolicyService;

class UserResponceController extends Controller
{
    public function index()
    {
        return auth('sanctum')->user();
    }

    public function updateUser(UserEditRequest $request, $id)
    {
        $user = User::find($id);

        if(UserPolicyService::canEditProfile($user)) return UserPolicyService::toProfile(true);

        $user->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ]);

        if ($request->file('images')){
            $request->user()->changeImg($request->file('images'), $user);
        }

        return ['message' => 'Профиль изменен'];
    }
}
