<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalService extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $table = "additional_services";
    protected $fillable = [
        'id',
        'key',
        'photos',
        'name',
        'price',
        'description',
    ];

    protected $dates = ['deleted_at'];
}
