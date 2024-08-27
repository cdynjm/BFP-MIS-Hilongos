<?php

namespace App\Http\Controllers\Pages\Admin;

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

use App\Models\User;
use App\Models\Personnel;

class PersonnelController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function personnel() {

        $personnel = Personnel::with((new Personnel)->relation)->get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Admin/Personnel', [
            'auth' => Auth::user(),
            'personnel' => $personnel
        ]);
    }

    public function createPersonnel(Request $request) {

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

        $personnel = Personnel::create([
            'name' => $request->name,
            'position' => $request->position,
            'contactNumber' => $request->contactNumber,
            'picture' => $filename
         ]);

        User::create([
            'personnelID' => $personnel->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2
        ]);

    }

    public function updatePersonnel(Request $request) {

        if(Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->aes->decrypt($request->id), 'personnelID')
            ]
        ])->fails()) { return back()->withErrors([
            'status' => 500,
            'error' => 'Email is already taken'
        ]); }

        if(!empty($request->file('file'))) {

            File::delete(public_path("storage/profile/".
                Personnel::where('id', $this->aes->decrypt($request->id))->first()->picture
            ));

            $timestamp = Carbon::now();
            $extension = $request->file->getClientOriginalExtension();
            $filename = \Str::slug($request->name.'-'.$timestamp).'.'.$extension;
            $transferfile = $request->file->storeAs('public/profile/', $filename); 

            Personnel::where('id', $this->aes->decrypt($request->id))->update(['picture' => $filename]);
        }
        
        Personnel::where('id', $this->aes->decrypt($request->id))->update([
            'name' => $request->name,
            'position' => $request->position,
            'contactNumber' => $request->contactNumber
        ]);
        

        User::where('personnelID', $this->aes->decrypt($request->id))->update([
            'email' => $request->email,
        ]);

        if(!empty($request->password)) {
            User::where('personnelID', $this->aes->decrypt($request->id))->update([
                'password' => Hash::make($request->password),
            ]);
        }
    }

    public function deletePersonnel(Request $request) {
        
        File::delete(public_path("storage/profile/".
            Personnel::where('id', $this->aes->decrypt($request->id))->first()->picture
        ));
        Personnel::where('id', $this->aes->decrypt($request->id))->delete();
        User::where('personnelID', $this->aes->decrypt($request->id))->delete();
    }
    
}
