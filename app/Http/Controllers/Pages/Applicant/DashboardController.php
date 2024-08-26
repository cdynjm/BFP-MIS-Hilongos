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
use App\Models\Personnel;

class DashboardController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function dashboard() {

        $pending = FireInspection::where('applicantID', Auth::user()->applicant->id)
            ->where('status', 1)->count();

        $scheduled = FireInspection::where('applicantID', Auth::user()->applicant->id)
            ->where('status', 2)->count();

        $archive = FireInspection::where('applicantID', Auth::user()->applicant->id)
                    ->where('status', 3)->count();
        
        $personnel = Personnel::with((new Personnel)->relation)->get();

        return Inertia::render('Applicant/Dashboard', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'pending' => $pending,
            'scheduled' => $scheduled,
            'archive' => $archive,
            'personnel' => $personnel,
 
            'pendingID' => $this->aes->encrypt(1),
            'scheduledID' => $this->aes->encrypt(2),
            'archiveID' => $this->aes->encrypt(3),
        ]);
    }

    public function createRequestInspection(Request $request) {

        
    }
}
