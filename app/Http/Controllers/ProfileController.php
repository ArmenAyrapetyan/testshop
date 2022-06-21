<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfileview(Request $request)
    {
        $userInfo = $request->user()->toArray();
        return view('profile', compact('userInfo'));
    }
}
