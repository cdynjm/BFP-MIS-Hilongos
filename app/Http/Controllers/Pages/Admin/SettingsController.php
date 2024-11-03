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
use App\Models\Applicant;
use App\Models\FireIncident;
use App\Models\Personnel;
use App\Models\SMSToken;
use App\Models\CertInfo;

class SettingsController extends Controller
{
    public function settings() {
        $sms = SMSToken::first();
        $cert = CertInfo::first();

        return Inertia::render('Admin/Settings', [
            'auth' => Auth::user()->load(Auth::user()->relation),
            'sms' => $sms,
            'cert' => $cert
        ]);
    }

    public function updateCertInfo(Request $request) {

        CertInfo::where('id', $request->id)->update([
            'contactNumber' => $request->contactNumber,
            'code' => $request->code
        ]);
    }

    public function smsAPI() { return SMSToken::first(); }

    public function updateSMS(Request $request) {

        SMSToken::where('id', $request->id)->update([
            'access_token' => $request->accessToken,
            'mobile_identity' => $request->mobileIdentity
        ]);
    }

    public function sendSMStoApplicant($id) {

        $inspection = FireInspection::where('id', $id)->first();

        $mobile_iden = $this->smsAPI()->mobile_identity;
        $mobile_token = $this->smsAPI()->access_token;

        $addresses = $inspection->applicant->contactNumber;
        $sms = 'Greetings '.$inspection->applicant->name.'\n\nYour Fire Safety Inspection has been successfully approved. We will be visiting your location at '.$inspection->address.' on '.date('F d, Y', strtotime($inspection->schedule)).' to conduct a follow-up inspection. Please ensure that all fire safety measures are in place and ready for review. Our team will assess compliance with the Fire Code, and any necessary recommendations will be provided. We appreciate your attention to maintaining a safe environment and thank you for your cooperation.\n\nBureau of Fire Protection\nHilongos, Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }

    public function sendSMStoPersonnel($id) {

        $inspection = FireInspection::where('id', $id)->first();

        $mobile_iden = $this->smsAPI()->mobile_identity;
        $mobile_token = $this->smsAPI()->access_token;

        $addresses = $inspection->personnel->contactNumber;
        $sms = 'Attention '.$inspection->personnel->name.'\n\nYou are hereby notified that you will be assigned to conduct the fire safety inspection at '.$inspection->address.' on '.date('F d, Y', strtotime($inspection->schedule)).'. Please prepare accordingly and ensure that all necessary equipment and documentation are ready for the inspection. Your role is crucial in ensuring compliance with fire safety standards, and your professionalism is appreciated. Thank you for your commitment to maintaining safety. Please check your account for more information.\n\nBureau of Fire Protection\nHilongos, Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }

    public function sendSMStoApplicantReschedule($id) {

        $inspection = FireInspection::where('id', $id)->first();

        $mobile_iden = $this->smsAPI()->mobile_identity;
        $mobile_token = $this->smsAPI()->access_token;

        $addresses = $inspection->applicant->contactNumber;
        $sms = 'Greetings '.$inspection->applicant->name.'\n\nYour Fire Safety Inspection has been rescheduled for visit/inspection. We will be revisiting your location at '.$inspection->address.' on '.date('F d, Y', strtotime($inspection->schedule)).' to conduct a follow-up inspection. Please ensure that all fire safety measures are in already complied and ready for review. Our team will assess compliance with the Fire Code, and any necessary recommendations will be provided. We appreciate your attention to maintaining a safe environment and thank you for your cooperation.\n\nBureau of Fire Protection\nHilongos, Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }

    public function sendSMStoPersonnelReschedule($id) {

        $inspection = FireInspection::where('id', $id)->first();

        $mobile_iden = $this->smsAPI()->mobile_identity;
        $mobile_token = $this->smsAPI()->access_token;

        $addresses = $inspection->personnel->contactNumber;
        $sms = 'Attention '.$inspection->personnel->name.'\n\nYou are hereby notified that you will be assigned to conduct the fire safety revisit inspection at '.$inspection->address.' on '.date('F d, Y', strtotime($inspection->schedule)).'. Please prepare accordingly and ensure that all of their necessary equipment and requirements are already complied and are ready for inspection. Your role is crucial in ensuring compliance with fire safety standards, and your professionalism is appreciated. Thank you for your commitment to maintaining safety. Please check your account for more information.\n\nBureau of Fire Protection\nHilongos, Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }
}
