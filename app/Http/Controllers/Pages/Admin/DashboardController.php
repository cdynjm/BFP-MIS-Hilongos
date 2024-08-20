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

class DashboardController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function dashboard() {
        
        $pending = FireInspection::where('status', 1)->count();

        $scheduled = FireInspection::where('status', 2)->count();

        $archive = FireInspection::where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.date('Y').'%')->count();

        $fireIncidentAnalytics = FireIncident::where('date', 'like', '%'.date('Y').'%')->get();

        return Inertia::render('Admin/Dashboard', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'pending' => $pending,
            'scheduled' => $scheduled,
            'archive' => $archive,
            'fireIncident' => $fireIncident,

            'pendingID' => $this->aes->encrypt(1),
            'scheduledID' => $this->aes->encrypt(2),
            'archiveID' => $this->aes->encrypt(3),

            'fireIncidentAnalytics' => $fireIncidentAnalytics,
            'year' => date('Y')
        ]);
    }

    public function searchYear(Request $request) {

        $pending = FireInspection::where('status', 1)->count();

        $scheduled = FireInspection::where('status', 2)->count();

        $archive = FireInspection::where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.$request->search.'%')->count();

        $fireIncidentAnalytics = FireIncident::where('date', 'like', '%'.$request->search.'%')->get();

        return Inertia::render('Admin/Dashboard', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'pending' => $pending,
            'scheduled' => $scheduled,
            'archive' => $archive,
            'fireIncident' => $fireIncident,

            'pendingID' => $this->aes->encrypt(1),
            'scheduledID' => $this->aes->encrypt(2),
            'archiveID' => $this->aes->encrypt(3),

            'fireIncidentAnalytics' => $fireIncidentAnalytics,
            'year' => $request->search
        ]);
    }
}
