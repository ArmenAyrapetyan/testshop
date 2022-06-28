<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfileview(Request $request)
    {
        $userInfo = User::where('id', '=', $request->user()->id)->first();
        $products = Product::all();
        return view('profile.show', compact('userInfo', 'products'));
    }
}
