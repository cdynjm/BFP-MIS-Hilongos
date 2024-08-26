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

class InspectionController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function inspections(Request $request) {

        if($this->aes->decrypt($request->id) == 1) {
            $raw = FireInspection::with((new FireInspection)->relation)
                ->where('applicantID', Auth::user()->applicant->id)
                ->where('status', 1)
                ->get();
            $id = 1;
        }

        if($this->aes->decrypt($request->id) == 2) {
            $raw = FireInspection::with((new FireInspection)->relation)
                ->where('applicantID', Auth::user()->applicant->id)
                ->where('status', 2)
                ->get();
            $id = 2;
        }

        if($this->aes->decrypt($request->id) == 3) {
            $raw = FireInspection::with((new FireInspection)->relation)
                ->where('applicantID', Auth::user()->applicant->id)
                ->where('status', 3)
                ->get();
            $id = 3;
        }

        $inspections = $raw->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Applicant/Inspections', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'id' => $id,
            'inspections' => $inspections
        ]);
    }

    public function deleteInspection(Request $request) {
        FireInspection::where('id', $this->aes->decrypt($request->id))->delete();
    }

    public function certificate(Request $request) {

        $fireInspection = FireInspection::where('id', $this->aes->decrypt($request->id))->first();

        if($fireInspection->certType == 1)
            return view('FSEC', ['fi' => $fireInspection]);
        if($fireInspection->certType == 2 || $fireInspection->certType == 3)
            return view('FSIC', ['fi' => $fireInspection]);
    }
}
