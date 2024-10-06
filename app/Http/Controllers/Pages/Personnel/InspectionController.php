<?php

namespace App\Http\Controllers\Pages\Personnel;

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

class InspectionController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function inspections(Request $request) {

        if($this->aes->decrypt($request->id) == 2) {
            $raw = FireInspection::with((new FireInspection)->relation)
                ->where('personnelID', Auth::user()->personnel->id)
                ->where('status', 2)->get();
            $id = 2;
        }

        if($this->aes->decrypt($request->id) == 3) {
            $raw = FireInspection::with((new FireInspection)->relation)
                ->where('personnelID', Auth::user()->personnel->id)
                ->where('status',3)->get();
            $id = 3;
        }

        $inspections = $raw->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Personnel/Inspections', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'id' => $id,
            'inspections' => $inspections,
        ]);
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
}
