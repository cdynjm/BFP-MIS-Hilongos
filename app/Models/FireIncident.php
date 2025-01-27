<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FireIncident extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fire_incident';

    public $relation = ['brgy'];

    protected $fillable = [
        'owner',
        'location',
        'fireAlarmLevel',
        'date',
        'time',
        'casualties',
        'fireCause',
        'injuries',
        'structureType',
        'estimatedValueLoss'
    ];

    public function brgy() {
        return $this->hasOne(Barangay::class, 'brgyCode', 'location');
    }
}
