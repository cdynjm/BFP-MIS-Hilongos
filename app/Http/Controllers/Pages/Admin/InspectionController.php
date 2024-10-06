<?php

namespace App\Http\Controllers\Pages\Admin;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\FireInspection;
use App\Models\Personnel;
use App\Models\Municipal;
use App\Models\Barangay;

use App\Http\Controllers\Pages\Admin\SMSController;

class InspectionController extends Controller
{
    public function __construct(
        protected AESCipher $aes,
        protected SMSController $sms
    ) {}

    public function inspections(Request $request) {

        $municipal = Municipal::where('id', 979)->first();
        $barangay = Barangay::where('citymunCode', $municipal->citymunCode)->get();

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
            'today' => date('Y-m-d'),
            'municipal' => $municipal,
            'barangay' => $barangay
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

    public function completeInspection(Request $request) {
        FireInspection::where('id', $this->aes->decrypt($request->id))->update(['status' => 3]);
    }

    public function uploadForm(Request $request) {

        $timestamp = Carbon::now();

        $extension = $request->file->getClientOriginalExtension();
        $filename = \Str::slug($request->name.'-checklist-form-'.$timestamp).'.'.$extension;
        $transferfile = $request->file->storeAs('public/files/', $filename); 

        $pictureExtension = $request->picture->getClientOriginalExtension();
        $pictureFilename = \Str::slug($request->name.'-picture-'.$timestamp).'.'.$pictureExtension;
        $transferfile = $request->picture->storeAs('public/files/', $pictureFilename); 

        FireInspection::where('id', $this->aes->decrypt($request->id))->update([
            'file' => $filename,
            'picture' => $pictureFilename
        ]);
    }

    public function deleteForm(Request $request) {

        $get = FireInspection::where('id', $this->aes->decrypt($request->id))->first();

        File::delete(public_path("storage/files/{$get->file}"));
        File::delete(public_path("storage/files/{$get->picture}"));

        FireInspection::where('id', $this->aes->decrypt($request->id))->update([
            'file' => null,
            'picture' => null
        ]);
    }

    public function reschedule(Request $request) {
        FireInspection::where('id', $this->aes->decrypt($request->id))->update(['schedule' => $request->date]);

        $this->sms->sendSMStoApplicantReschedule($this->aes->decrypt($request->id));
        $this->sms->sendSMStoPersonnelReschedule($this->aes->decrypt($request->id));
    }

    public function generateCertificate(Request $request) {

        $recommendApproval = Personnel::where('id', $this->aes->decrypt($request->recommendedApproval))->first();
        $approved = Personnel::where('id', $this->aes->decrypt($request->approvedBy))->first();


        FireInspection::where('id', $this->aes->decrypt($request->id))->update([
            'buildingName' => $request->building,
            'address' => $request->address,
            'owner' => $request->owner,
            'amountPaid' => $request->amountPaid,
            'ORNumber' => $request->ORNumber,
            'dateOR' => $request->date,
            'recommendApproval' => $recommendApproval->name,
            'recommendPosition' => $recommendApproval->position,
            'approved' => $approved->name,
            'approvedPosition' => $approved->position,
            'certStatus' => 1
        ]);

        if($request->certType == 1) {
            FireInspection::where('id', $this->aes->decrypt($request->id))->update([
                'FSECNumber' => $request->fsicfsecNumber,
                'dateFSEC' => $request->date
            ]);
        }

        if($request->certType == 2 || $request->certType == 3) {
            FireInspection::where('id', $this->aes->decrypt($request->id))->update([
                'description' => $request->description,
                'validFrom' => $request->validFrom,
                'FSICNumber' => $request->fsicfsecNumber,
                'dateFSIC' => $request->date
            ]);
        }
    }

    public function certificate(Request $request) {

        $fireInspection = FireInspection::where('id', $this->aes->decrypt($request->id))->first();

        if($fireInspection->certType == 1)
            return view('FSEC', ['fi' => $fireInspection]);
        if($fireInspection->certType == 2 || $fireInspection->certType == 3)
            return view('FSIC', ['fi' => $fireInspection]);
    }
}
