<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceUsage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "service_usages";
    protected $fillable = [
        'id',
        'key',
        'additional_service_id',
        'reservation_id',
        'number_of_uses',
        'total_service_cost',
    ];
    protected $dates = ['deleted_at'];

    public function additionService()
    {
        return $this->belongsTo(AdditionalService::class, 'additional_service_id');
    }

    public function getTotalServiceCost()
    {
        return $this->additionService->price * $this->number_of_uses;
    }
}
