<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
