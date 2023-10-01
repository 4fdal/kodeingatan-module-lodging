<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";
    protected $fillable = [
        'id',
        'key',
        'identity_number',
        'name',
        'address',
        'email',
        'phone_number',
    ];
}
