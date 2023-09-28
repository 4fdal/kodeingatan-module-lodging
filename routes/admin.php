<?php

use App\Utils\KiAdminRoute;
use Illuminate\Support\Facades\Route;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomController;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomTypeController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ServiceController;

Route::middleware('web', 'auth', 'permission:admin')->prefix('/admin')->as('admin.')->group(function () {
    KiAdminRoute::makeCRUD(RoomTypeController::class, "/room_type", "room_type.");
    KiAdminRoute::makeCRUD(RoomController::class, "/room", "room.");
    KiAdminRoute::makeCRUD(ServiceController::class, "/additional_service", "additional_service.");
});
