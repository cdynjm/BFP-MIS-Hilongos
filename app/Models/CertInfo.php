<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cert_info';

    protected $fillable = [
        'contactNumber',
        'code'
    ];
}
