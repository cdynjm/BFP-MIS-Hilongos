<?php

namespace App\Http\Controllers\Pages\Applicant;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;

use App\Models\User;
use App\Models\FireInspection;

class RequestInspectionController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function requestInspection() {

        return Inertia::render('Applicant/RequestInspection', [
            'auth' => Auth::user()->load(Auth::user()->relation)
        ]);
       
    }

    public function createFSEC(Request $request) {

        FireInspection::create([
            'applicantID' => Auth::user()->applicant->id,
            'buildingName' => $request->building,
            'address' => $request->address,
            'status' => 1,
            'certType' => 1
        ]);
    }

    public function createFSICOccupancy(Request $request) {

        FireInspection::create([
            'applicantID' => Auth::user()->applicant->id,
            'buildingName' => $request->building,
            'address' => $request->address,
            'status' => 1,
            'certType' => 2
        ]);
    }

    public function createFSICBusiness(Request $request) {

        FireInspection::create([
            'applicantID' => Auth::user()->applicant->id,
            'buildingName' => $request->building,
            'address' => $request->address,
            'status' => 1,
            'certType' => 3
        ]);
    }
}
