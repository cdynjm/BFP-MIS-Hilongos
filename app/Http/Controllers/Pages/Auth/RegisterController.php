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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Auth\Events\Registered;

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

        $timestamp = Carbon::now();
        $extension = $request->file->getClientOriginalExtension();
        $filename = \Str::slug($request->name.'-'.$timestamp).'.'.$extension;
        $transferfile = $request->file->storeAs('public/profile/', $filename); 

        $applicant = Applicant::create([
            'name' => $request->name,
            'contactNumber' => $request->contactNumber,
            'picture' => $filename
        ]);

        $user = User::create([
            'applicantID' => $applicant->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        Auth::login($user, true);
        
        event(new Registered($user));
        
        return redirect('/applicant/dashboard');
    }
}
