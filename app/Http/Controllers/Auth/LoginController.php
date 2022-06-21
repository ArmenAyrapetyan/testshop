<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            '_token' => 'required',
        ]);

        if (Auth::guard()->attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Ошибка авторизации. Логин или паоль введены неверно',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
