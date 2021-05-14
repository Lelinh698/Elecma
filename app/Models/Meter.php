<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
//    use HasFactory;
    protected $table = 'meters';
    public $timestamps = false;

    protected $fillable = [
        'meter_address',
        'type',
        'customer_id'
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function meter_reading() {
        return $this->hasMany('App\Models\Meter_reading');
    }
}
