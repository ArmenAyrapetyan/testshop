<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Jobs\BlockUser;
use App\Models\Image;
use App\Models\User;
use App\Models\UserRole;
use App\Services\FileManager;

class UserController extends Controller
{
    public function edit(User $user)
    {
        if (auth()->user()->cannot('editProfile', $user)){
            return redirect()->route('profile')->withErrors([
               'error' => 'Доступ запрещен'
            ]);
        }

        return view('crud.user.edit', compact('user'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        if (auth()->user()->cannot('editProfile', $user)){
            return redirect()->route('profile')->withErrors([
                'error' => 'Доступ запрещен'
            ]);
        }

        $user->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ]);

        if ($request->file('images')){
            $oldimgpath = Image::where('imageable_id', '=', $user->id)
                ->where('imageable_type', '=', User::class)
                ->first();

            FileManager::deleteImage($oldimgpath->path);

            $oldimgpath->delete();

            $file = $request->file('images');

            FileManager::saveImage($file, $user->id, "User");
        }

        return redirect()->route('profile')->with([
           'success' => 'Профиль изменен',
        ]);
    }

    public function blockUser($id)
    {
        if (auth()->user()->cannot('isAdmin', User::class)){
            return redirect()->route('profile')->withErrors([
                'error' => 'Доступ запрещен'
            ]);
        }

        $user = User::find($id);
        $user->role_id = UserRole::firstWhere('name', 'Заблокирован')->id;
        $user->save();

        switch ($user->ban_count){
            case 0:
                BlockUser::dispatch($user)->delay(now()->addDays(10));
                $user->ban_count += 1;
                $user->save();
                break;
            case 1:
                BlockUser::dispatch($user)->delay(now()->addDays(20));
                $user->ban_count += 1;
                $user->save();
                break;
            case 2:
                BlockUser::dispatch($user)->delay(now()->addDays(30));
                $user->ban_count += 1;
                $user->save();
                break;
            case 3:
                $user->ban_count += 1;
                $user->save();
                break;
        }
        return back()->with([
            'success' => 'Пользователь заблокирован',
        ]);
    }
}
