<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfileview(Request $request)
    {
        $userInfo = User::where('id', '=', $request->user()->id)->first();;
        return view('profile', compact('userInfo'));
    }
}
