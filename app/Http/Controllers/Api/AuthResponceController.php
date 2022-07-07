<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class AuthResponceController extends Controller
{
    public function enter(LoginRequest $request)
    {
        $message = [
          'message' => 'Ошибка авторизации не верный логин или пароль',
        ];

        if(Auth::guard()->attempt($request->only(['email', 'password']))){
            $message = [
                'id' => auth()->user()->id,
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
                'message' => 'Авторизация пройдена успешно',
            ];
        }
        return $message;
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
        ]);

        $token = $user->createToken('tokens')->plainTextToken;

        $image = Image::create([
            'path' => $path,
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
        ]);

        $message = [
            'id' => 0,
            'message' => 'Регистрация провалена',
        ];

        if ($user && $image) {
            $user->sendEmailVerificationNotification();
            $message = [
                'id' => $user->id,
                'message' => 'Регистрация прошла успешно',
                'token' => $token,
                'verify' => 'Вам отправлено письмо верификации',
            ];
        }

        return $message;
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::firstWhere('email', $request['email']);

        $user->sendEmailVerificationNotification();

        $message = [
            'message' => 'Вам отправленно письмо верификации'
        ];

        return $message;
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        Password::sendResetLink(
            $request->only('email')
        );

        $message = [
            'message' => 'Вам отправленно письмо восстановления пароля'
        ];

        return $message;
    }

    public function logout()
    {
        auth()->logout();

        $message = [
            'message' => 'Вы вышли из учетной записи'
        ];

        return $message;
    }
}
