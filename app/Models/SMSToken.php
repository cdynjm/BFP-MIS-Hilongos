<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SMSToken extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sms_token_identity';

    protected $fillable = [
        'access_token',
        'mobile_identity'
    ];
}
