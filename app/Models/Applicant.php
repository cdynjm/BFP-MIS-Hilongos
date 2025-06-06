<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;
    
    public $relation = ['user'];

    protected $table = 'applicant';

    protected $fillable = [
        'name',
        'contactNumber',
        'picture'
    ];

    public function user() {
        return $this->hasOne(User::class, 'applicantID', 'id')->withTrashed();
    }
}
