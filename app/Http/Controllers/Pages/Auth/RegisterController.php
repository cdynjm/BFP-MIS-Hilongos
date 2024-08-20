<?php

namespace App\Http\Controllers\Pages\Auth;

use Hash;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Applicant;

class RegisterController extends Controller
{
    public function register() {
        return Inertia::render('Auth/Register');
    }

    public function authenticate(Request $request) {

        if(Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
            ]
        ])->fails()) { return back()->withErrors([
            'status' => 500,
            'error' => 'Email is already taken'
        ]); }

        $applicant = Applicant::create([
            'name' => $request->name,
            'contactNumber' => $request->contactNumber
        ]);

        $user = User::create([
            'applicantID' => $applicant->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        Auth::login($user, true);
        
        return redirect('/applicant/dashboard');
    }
}
