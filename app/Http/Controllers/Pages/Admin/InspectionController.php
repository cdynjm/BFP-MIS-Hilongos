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
use App\Models\Personnel;
use App\Http\Controllers\Pages\Admin\SMSController;

class InspectionController extends Controller
{
    public function __construct(
        protected AESCipher $aes,
        protected SMSController $sms
    ) {}

    public function inspections(Request $request) {

        if($this->aes->decrypt($request->id) == 1) {
            $raw = FireInspection::with((new FireInspection)->relation)->where('status', 1)->get();
            $id = 1;
        }

        if($this->aes->decrypt($request->id) == 2) {
            $raw = FireInspection::with((new FireInspection)->relation)->where('status', 2)->get();
            $id = 2;
        }

        if($this->aes->decrypt($request->id) == 3) {
            $raw = FireInspection::with((new FireInspection)->relation)->where('status', 3)->get();
            $id = 3;
        }

        $inspections = $raw->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        $personnel = Personnel::get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Admin/Inspections', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'id' => $id,
            'inspections' => $inspections,
            'personnel' => $personnel,
            'today' => date('Y-m-d')
        ]);
    }

    public function scheduleInspection(Request $request) {
        
        FireInspection::where('id', $this->aes->decrypt($request->id))->update([
            'schedule' => $request->schedule,
            'personnelID' => $this->aes->decrypt($request->personnel),
            'status' => 2
        ]);

        $this->sms->sendSMStoApplicant($this->aes->decrypt($request->id));
        $this->sms->sendSMStoPersonnel($this->aes->decrypt($request->id));
    }
}
