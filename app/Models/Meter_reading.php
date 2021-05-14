<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter_reading extends Model
{
//    use HasFactory;
    protected $table = 'meter_readings';
    public $timestamps = false;

    protected $fillable = [
        'meter_id',
        'number',
        'month',
        'year'
    ];

    public function meter() {
        return $this->belongsTo('App\Models\Meter', 'meter_id');
    }
}
