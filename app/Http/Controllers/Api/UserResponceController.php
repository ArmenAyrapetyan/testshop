<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Models\Image;
use App\Models\User;
use App\Services\FileManager;

class UserResponceController extends Controller
{
    public function index()
    {
        return auth('sanctum')->user();
    }

    public function updateUser(UserEditRequest $request, $id)
    {
        $user = User::find($id);
        if (auth('sanctum')->user()->cannot('editProfile', $user)){
            return [
                'message' => 'Доступ запрещен'
            ];
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

            $file = $request->file('avatar');

            FileManager::saveImage($file, $user->id, "User");
        }

        return [
            'message' => 'Профиль изменен',
        ];
    }
}
