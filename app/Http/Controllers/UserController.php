<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Jobs\BlockUser;
use App\Models\User;
use App\Models\UserRole;
use App\Services\UserPolicyService;

class UserController extends Controller
{
    public function edit(User $user)
    {
        if(UserPolicyService::canEditProfile($user)) return UserPolicyService::toProfile();

        return view('crud.user.edit', compact('user'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        if(UserPolicyService::canEditProfile($user)) return UserPolicyService::toProfile();

        $user->update($request->all());

        if ($request->file('images')){
            $request->user()->changeImg($request->file('images'), $user);
        }

        return redirect()->route('profile')->with(['success' => 'Профиль изменен']);
    }

    public function blockUser($id)
    {
        if(UserPolicyService::isAdminUser()) return UserPolicyService::toProfile();

        $user = User::find($id);
        $user->role_id = UserRole::USER_BANED;
        $user->save();

        $this->ban($user);

        return back()->with(['success' => 'Пользователь заблокирован']);
    }

    protected function ban($user)
    {
        switch ($user->ban_count){
            case 0:
                BlockUser::dispatch($user)->delay(now()->addDays(10));
                $user->ban_count += 1;
                $user->save();
                break;
            case 1:
                BlockUser::dispatch($user)->delay(now()->addMonth());
                $user->ban_count += 1;
                $user->save();
                break;
            case 2:
                BlockUser::dispatch($user)->delay(now()->addMonths(3));
                $user->ban_count += 1;
                $user->save();
                break;
            case 3:
                $user->ban_count += 1;
                $user->save();
                break;
        }
    }
}
