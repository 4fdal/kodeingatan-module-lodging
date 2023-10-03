<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "reservations";
    protected $fillable = [
        'id',
        'key',
        'customer_id',
        'room_id',
        'total_stay_days',
        'checkin_date',
        'checkout_date',
        'status',
        'payment_status',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', null);
    }

    public function serviceUsages()
    {
        return $this->hasMany(ServiceUsage::class, 'reservation_id', 'id');
    }

    public function getTotalCost()
    {

        $total_cost = $this->total_stay_days * $this->room->price_per_night;
        foreach ($this->service_usages ?? [] as $index => $service_usage) {
            $total_cost += $service_usage->getTotalServiceCost();
        }

        return $total_cost;
    }

    public function getTaxTotalCost()
    {
        return $this->getTotalCost() * (2 / 100);
    }

    public function getTotalBill()
    {
        return $this->getTotalCost() - $this->getTaxTotalCost();
    }
}
