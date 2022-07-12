<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with(['resent' => 'Вам отправленно повторное письмо']);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home')->with(['success' => 'Почта подтверждена']);
    }

    public function show()
    {
        return view('auth.verify');
    }
}
