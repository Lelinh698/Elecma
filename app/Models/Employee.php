<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
//    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'username', 'password', 'department_id'
    ];

    public function department() {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}
