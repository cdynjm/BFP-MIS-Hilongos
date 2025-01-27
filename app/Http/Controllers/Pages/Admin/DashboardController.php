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
use App\Models\Municipal;
use App\Models\Barangay;

class DashboardController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function dashboard() {
        
        $municipal = Municipal::where('id', 979)->first();
        $barangay = Barangay::where('citymunCode', $municipal->citymunCode)->get();

        $pending = FireInspection::where('status', 1)->count();

        $scheduled = FireInspection::where('status', 2)->count();

        $archive = FireInspection::where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.date('Y').'%')->count();

        $fireIncidentAnalytics = FireIncident::with((new FireIncident)->relation)->whereYear('date', date('Y'))->get();

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
            'year' => date('Y'),
            'municipal' => $municipal,
            'barangay' => $barangay
        ]);
    }

    public function searchYear(Request $request) {
        
        $municipal = Municipal::where('id', 979)->first();
        $barangay = Barangay::where('citymunCode', $municipal->citymunCode)->get();

        $pending = FireInspection::where('status', 1)->count();

        $scheduled = FireInspection::where('status', 2)->count();

        $archive = FireInspection::where('status', 3)->count();

        $fireIncident = FireIncident::where('date', 'like', '%'.$request->search.'%')->count();

        $fireIncidentAnalytics = FireIncident::with((new FireIncident)->relation)->whereYear('date', $request->search)->get();

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
            'year' => $request->search,
            'municipal' => $municipal,
            'barangay' => $barangay
        ]);
    }
}
