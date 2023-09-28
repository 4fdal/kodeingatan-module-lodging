<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    use HasFactory;

    protected $table = "additional_services";
    protected $fillable = [
        'id',
        'key',
        'photos',
        'name',
        'price',
        'description',
    ];
}
