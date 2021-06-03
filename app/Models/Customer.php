<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    public $timestamps = false;
//    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'username', 'password', 'department_id'
    ];

    public function department() {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function meter() {
        return $this->hasOne('App\Models\Meter');
    }

    public function bills() {
        return $this->hasMany('App\Models\Bill');
    }
}
