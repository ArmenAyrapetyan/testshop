<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('crud.user.edit', compact('user'));
    }

    public function update(UserEditRequest $request, User $user)
    {
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
}
