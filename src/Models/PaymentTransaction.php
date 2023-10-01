<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = "payment_transactions";
    protected $fillable = [
        'id',
        'key',
        'reservation_id',
        'transaction_data',
        'payment_methods',
        'total_cost',
        'tax',
        'total_bill',
    ];
}
