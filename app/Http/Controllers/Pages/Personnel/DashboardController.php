<?php

namespace App\Http\Controllers\Pages\Personnel;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;

use App\Models\User;
use App\Models\FireInspection;
use App\Models\FireIncident;

class DashboardController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function dashboard() {

        $scheduled = FireInspection::where('personnelID', Auth::user()->personnel->id)
                ->where('status', 2)->count();

        $archive = FireInspection::where('personnelID', Auth::user()->personnel->id)
                ->where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.date('Y').'%')->count();

        $fireIncidentAnalytics = FireIncident::where('date', 'like', '%'.date('Y').'%')->get();

        return Inertia::render('Personnel/Dashboard', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'scheduled' => $scheduled,
            'archive' => $archive,
            'fireIncident' => $fireIncident,

            'scheduledID' => $this->aes->encrypt(2),
            'archiveID' => $this->aes->encrypt(3),

            'fireIncidentAnalytics' => $fireIncidentAnalytics,
            'year' => date('Y')
        ]);
    }

    public function searchYear(Request $request) {

        $scheduled = FireInspection::where('personnelID', Auth::user()->personnel->id)
                ->where('status', 2)->count();

        $archive = FireInspection::where('personnelID', Auth::user()->personnel->id)
                ->where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.$request->search.'%')->count();

        $fireIncidentAnalytics = FireIncident::where('date', 'like', '%'.$request->search.'%')->get();

        return Inertia::render('Personnel/Dashboard', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'scheduled' => $scheduled,
            'archive' => $archive,
            'fireIncident' => $fireIncident,

            'scheduledID' => $this->aes->encrypt(2),
            'archiveID' => $this->aes->encrypt(3),

            'fireIncidentAnalytics' => $fireIncidentAnalytics,
            'year' => $request->search
        ]);
    }
}
