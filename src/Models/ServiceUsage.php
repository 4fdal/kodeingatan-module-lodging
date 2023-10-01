<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUsage extends Model
{
    use HasFactory;

    protected $table = "service_usages";
    protected $fillable = [
        'id',
        'key',
        'additional_service_id',
        'reservation_id',
        'number_of_uses',
        'total_service_cost',
    ];

    public function additionService()
    {
        return $this->belongsTo(AdditionalService::class, 'additional_service_id');
    }

    public function getTotalServiceCost()
    {
        return $this->additional_service->price * $this->number_of_uses;
    }
}
