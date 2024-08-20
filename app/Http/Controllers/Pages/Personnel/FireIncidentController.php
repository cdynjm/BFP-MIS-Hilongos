<?php

namespace App\Http\Controllers\Pages\Personnel;

use Hash;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\AESCipher;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Personnel;
use App\Models\FireIncident;

class FireIncidentController extends Controller
{
    public function __construct(protected AESCipher $aes) {}

    public function fireIncident() {

        $fireIncident = FireIncident::where('date', 'like', '%'.date('Y').'%')->get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Personnel/Fire-Incident',[
            'auth' => Auth::user()->load(Auth::user()->relation),
            'fireIncident' => $fireIncident,
            'year' => date('Y')
        ]);
    }

    public function searchYear(Request $request) {

        $fireIncident = FireIncident::where('date', 'like', '%'.$request->search.'%')->get()

        ->map(function ($data) {
            $array = $data->toArray();
            $array['id'] = $this->aes->encrypt($data->id);
            return $array;
        });

        return Inertia::render('Personnel/Fire-Incident',[
            'auth' => Auth::user()->load(Auth::user()->relation),
            'fireIncident' => $fireIncident,
            'year' => $request->search
        ]);
    }

    public function createFireIncident(Request $request ){

        FireIncident::create([
            'owner' => $request->owner,
            'location' => $request->location,
            'fireAlarmLevel' => $request->fireAlarmLevel,
            'date' => $request->date,
            'time' => $request->time,
            'casualties' => $request->casualties,
            'fireCause' => $request->fireCause,
            'injuries' => $request->injuries,
            'structureType' => $request->structureType,
            'estimatedValueLoss' => $request->estimatedValueLoss
        ]);
    }

    public function updateFireIncident(Request $request ){

        FireIncident::where('id', $this->aes->decrypt($request->id))->update([
            'owner' => $request->owner,
            'location' => $request->location,
            'fireAlarmLevel' => $request->fireAlarmLevel,
            'date' => $request->date,
            'time' => $request->time,
            'casualties' => $request->casualties,
            'fireCause' => $request->fireCause,
            'injuries' => $request->injuries,
            'structureType' => $request->structureType,
            'estimatedValueLoss' => $request->estimatedValueLoss
        ]);
    }

    public function deleteFireIncident(Request $request ){
        FireIncident::where('id', $this->aes->decrypt($request->id))->delete();
    }
}
