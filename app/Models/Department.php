<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
//    use HasFactory;
    protected $table = 'departments';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address'
    ];

    public function customer() {
        return $this->hasMany('App\Models\Customer');
    }

    public function employee() {
        return $this->hasMany('App\Models\Employee');
    }
}
