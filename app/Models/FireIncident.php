<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FireIncident extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fire_incident';

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
}
