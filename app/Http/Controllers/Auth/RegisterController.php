<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Image;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $file = $request->file('avatar');

        $upload_folder = "public/images/" . date('Y-m-d');
        $name = $file->getClientOriginalName();
        $name = strstr($name, '.', true);
        $extension = $file->getClientOriginalExtension();
        $name = $name . date('Y-m-d') . '.' . $extension;
        $path = Storage::putFileAs($upload_folder, $file, $name);

        $path = str_replace('public', 'storage', $path);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
//            'remember_token' => '',
        ]);



        $image = Image::create([
            'path' => $path,
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
        ]);

        if ($user && $image) {
            auth()->login($user);
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice');
        }

        return redirect()->route('register');
    }
}
