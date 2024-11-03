<?php

namespace App\Http\Controllers\Pages\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    public function notVerified() {
        if(Auth::user()->email_verified_at == null)
            return Inertia::render('Auth/Not-Verified');
        else {
            if(Auth::user()->role == 1)
                return redirect(RouteServiceProvider::ADMIN);
            if(Auth::user()->role == 2)
                return redirect(RouteServiceProvider::PERSONNEL);
            if(Auth::user()->role == 3)
                return redirect(RouteServiceProvider::APPLICANT);
        }
            
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill($request);
        return Inertia::render('Auth/Verified');
    }
}
