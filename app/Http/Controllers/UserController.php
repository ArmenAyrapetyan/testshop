<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Jobs\BlockUser;
use App\Models\Image;
use App\Models\User;
use App\Models\UserRole;
use Couchbase\UserManager;
use Illuminate\Support\Facades\Storage;

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

        if ($request->file('avatar')){
            $oldimgpath = Image::where('imageable_id', '=', $user->id)
                ->where('imageable_type', '=', User::class)
                ->first();

//            Storage::delete($oldimgpath->path);

            $oldimgpath->delete();

            $file = $request->file('avatar');

            $upload_folder = "public/images/" . date('Y-m-d');
            $name = $file->getClientOriginalName();
            $name = strstr($name, '.', true);
            $extension = $file->getClientOriginalExtension();
            $name = $name . date('Y-m-d') . '.' . $extension;
            $path = Storage::putFileAs($upload_folder, $file, $name);

            $path = str_replace('public', 'storage', $path);

            Image::create([
                'path' => $path,
                'imageable_type' => User::class,
                'imageable_id' => $user->id,
            ]);
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
