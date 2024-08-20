<?php

namespace App\Http\Controllers\Layouts;

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
use App\Models\FireInspection;
use App\Models\FireIncident;

class NavbarController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function notification() {
        
        if(Auth::user()->role == 1) {
            $notifCount = FireInspection::where('status', 1)->count();
            $notif = FireInspection::with((new FireInspection)->relation)->where('status', 1)->get();

            return response()->json([
                'notifCount' => $notifCount,
                'notif' => $notif
            ]);
        }

        if(Auth::user()->role == 2) {

            $notifCount = FireInspection::where('status', 2)
                ->where('personnelID', Auth::user()->personnel->id)
                ->count();

            $notif = FireInspection::with((new FireInspection)->relation)
                ->where('personnelID', Auth::user()->personnel->id)
                ->where('status', 2)
                ->get();

            return response()->json([
                'notifCount' => $notifCount,
                'notif' => $notif
            ]);
        }

        if(Auth::user()->role == 3) {
            
            $notifCount = FireInspection::where('status', 2)
                ->where('applicantID', Auth::user()->applicant->id)
                ->count();

            $notif = FireInspection::with((new FireInspection)->relation)
                ->where('applicantID', Auth::user()->applicant->id)
                ->where('status', 2)
                ->get();

            return response()->json([
                'notifCount' => $notifCount,
                'notif' => $notif
            ]);
        }
    }

    public function updateProfile(Request $request) {

        if(Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()->id)
            ]
        ])->fails()) { return back()->withErrors([
            'status' => 500,
            'error' => 'Email is already taken'
        ]); }

        if(Auth::user()->role == 1) {
            
    
            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if(!empty($request->password)) {
                Auth::user()->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        if(Auth::user()->role == 2) {
    
            Auth::user()->personnel->update([
                'name' => $request->name,
                'contactNumber' => $request->contactNumber
            ]);

            Auth::user()->update([
                'email' => $request->email,
            ]);

            if(!empty($request->password)) {
                Auth::user()->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        if(Auth::user()->role == 3) {

            Auth::user()->applicant->update([
                'name' => $request->name,
                'contactNumber' => $request->contactNumber
            ]);

            Auth::user()->update([
                'email' => $request->email,
            ]);

            if(!empty($request->password)) {
                Auth::user()->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }
    }
}
