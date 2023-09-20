<?php

use App\Utils\KiAdminRoute;
use Illuminate\Support\Facades\Route;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomTypeController;

Route::middleware('web', 'auth', 'permission:admin')->prefix('/admin')->as('admin.')->group(function () {
    KiAdminRoute::makeCRUD(RoomTypeController::class, "/room_type", "room_type.");
    // KiAdminRoute::makeCRUD(RoomController::class, "/room", "room.");
});
