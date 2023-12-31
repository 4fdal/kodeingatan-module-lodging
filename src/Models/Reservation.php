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
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function serviceUsages()
    {
        return $this->hasMany(ServiceUsage::class, 'reservation_id', 'id');
    }

    public function getTotalRoomCost()
    {
        $room_cost = ($this->total_stay_days ?? 0) * ($this->room->price_per_night ?? 0);

        return $room_cost;
    }

    public function getTotalServiceCost()
    {
        $total_cost = 0;
        foreach ($this->serviceUsages ?? [] as $index => $service_usage) {
            $total_cost += $service_usage->getTotalServiceCost();
        }

        return $total_cost;
    }

    public function getTotalCost()
    {
        $room_cost = $this->getTotalRoomCost();
        $total_service_cost = $this->getTotalServiceCost();

        return $room_cost + $total_service_cost;
    }

    public function getTaxTotalCost()
    {
        return $this->getTotalCost() * (2 / 100);
    }

    public function getTotalBill()
    {
        return $this->getTotalCost() + $this->getTaxTotalCost();
    }
}
