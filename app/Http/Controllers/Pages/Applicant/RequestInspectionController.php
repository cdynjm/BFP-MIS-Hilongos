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
use App\Models\Municipal;
use App\Models\Barangay;

class RequestInspectionController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function requestInspection() {

        $municipal = Municipal::where('id', 979)->first();
        $barangay = Barangay::where('citymunCode', $municipal->citymunCode)->get();

        return Inertia::render('Applicant/RequestInspection', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'municipal' => $municipal,
            'barangay' => $barangay
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
