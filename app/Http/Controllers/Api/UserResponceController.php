<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResourse;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->file('avatar')){
            $oldimgpath = Image::where('imageable_id', '=', $user->id)
                ->where('imageable_type', '=', User::class)
                ->first();

            $path = "public/" . explode('storage/', $oldimgpath->path)[1];
            Storage::delete($path);

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

        return [
            'message' => 'Профиль изменен',
        ];
    }
}
