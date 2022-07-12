<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfileview(Request $request)
    {
        $userInfo = $request->user();
        $products = Product::all();
        return view('profile.show', compact('userInfo', 'products'));
    }
}
