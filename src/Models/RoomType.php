<?php

namespace Kodeingatan\Lodging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    protected $table = "room_types";
    protected $fillable = ['id', 'key', 'name', 'description'];
    protected $dates = ['deleted_at'];
}
