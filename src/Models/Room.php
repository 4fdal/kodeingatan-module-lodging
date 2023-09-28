<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = "rooms";

    protected $fillable = ['key', 'photo', 'name', 'room_type_id', 'price_per_night', 'availability', 'description'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}
