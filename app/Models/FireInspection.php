<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FireInspection extends Model
{
    use HasFactory, SoftDeletes;

    public $relation = ['personnel', 'applicant', 'user'];

    protected $table = 'fire_inspection';
    
    protected $fillable = [
        'applicantID',
        'buildingName',
        'address',
        'purok',
        'businessName',
        'businessNature',
        'FSECNumber',
        'dateFSEC',
        'FSICNumber',
        'dateFSIC',
        'owner',
        'description',
        'validFrom',
        'validUntil',
        'amountPaid',
        'ORNumber',
        'dateOR',
        'recommendApproval',
        'recommendPosition',
        'approved',
        'approvedPosition',
        'inspectionOrderNumber',
        'ditControlNumber',
        'buildingNumber',
        'schedule',
        'personnelID',
        'status',
        'certType',
        'certStatus',
        'file',
        'picture'
    ];

    public function personnel() {
        return $this->hasOne(Personnel::class, 'id', 'personnelID')->withTrashed();
    }
    public function applicant() {
        return $this->hasOne(Applicant::class, 'id', 'applicantID')->withTrashed();
    }
    public function user() {
        return $this->hasOne(User::class, 'applicantID', 'applicantID')->withTrashed();
    }
}
