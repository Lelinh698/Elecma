<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
//    use HasFactory;
    protected $table = 'bills';
    public $timestamps = false;
    const PAID = 1;
    const UNPAID = 0;

    protected $fillable = [
        'amount', 'from_date', 'to_date', 'paid_date',
        'paid_mode', 'status', 'customer_id', 'initial_number',
        'final_number', 'price_per_number'
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }
}
