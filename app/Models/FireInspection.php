<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireInspection extends Model
{
    
    public $relation = ['personnel', 'applicant'];

    protected $table = 'fire_inspection';
    
    protected $fillable = [
        'applicantID',
        'buildingName',
        'address',
        'businessName',
        'businessNature',
        'FSECNumber',
        'dateFSEC',
        'buildingPermit',
        'dateBuildingPermit',
        'FSICNumber',
        'dateFSIC',
        'permitNumber',
        'datePermitNumber',
        'fireInsurance',
        'dateFireInsurance',
        'schedule',
        'personnelID',
        'status'
    ];

    public function personnel() {
        return $this->hasOne(Personnel::class, 'id', 'personnelID');
    }
    public function applicant() {
        return $this->hasOne(Applicant::class, 'id', 'applicantID');
    }
}
