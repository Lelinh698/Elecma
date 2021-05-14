<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electricity_price extends Model
{
//    use HasFactory;
    protected $table = 'electricity_prices';
    public $timestamps = false;

    protected $fillable = [
        'from_number',
        'to_number',
        'price'
    ];
}
