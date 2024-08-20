<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    public $relation = ['user'];

    protected $table = 'personnel';

    protected $fillable = [
        'name',
        'position',
        'contactNumber'
    ];

    public function user() {
        return $this->hasOne(User::class, 'personnelID', 'id');
    }
}
