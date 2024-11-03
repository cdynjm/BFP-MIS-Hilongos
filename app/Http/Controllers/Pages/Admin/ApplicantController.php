<?php

namespace App\Http\Controllers\Pages\Admin;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;

use App\Models\User;
use App\Models\FireInspection;
use App\Models\FireIncident;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function applicants() {

        $applicant = Applicant::with((new Applicant)->relation)
        ->orderBy('name', 'ASC')
        ->get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Admin/Applicants', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'applicant' => $applicant,
            'total' => $applicant->count()
        ]);
    }

    public function applicantsRecords(Request $request) {

        $inspections = FireInspection::with((new FireInspection)->relation)
        ->where('applicantID', $this->aes->decrypt($request->id))
        ->orderBy('created_at', 'DESC')
        ->get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Admin/Applicant-Certificate-History', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'inspections' => $inspections
        ]);
    }
    
}
