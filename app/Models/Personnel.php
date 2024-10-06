<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory, SoftDeletes;

    public $relation = ['user'];

    protected $table = 'personnel';

    protected $fillable = [
        'name',
        'position',
        'contactNumber',
        'picture'
    ];

    public function user() {
        return $this->hasOne(User::class, 'personnelID', 'id')->withTrashed();
    }
}
