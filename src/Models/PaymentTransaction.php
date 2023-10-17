<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "payment_transactions";
    protected $fillable = [
        'id',
        'key',
        'reservation_id',
        'transaction_date',
        'payment_method',
        'total_cost',
        'tax',
        'total_bill',
    ];
    protected $dates = ['deleted_at'];
}
