<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

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
    protected $dates = ['deleted_at'];
}
