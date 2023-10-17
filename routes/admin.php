<?php

use App\Utils\KiAdminRoute;
use Illuminate\Support\Facades\Route;
use Kodeingatan\Lodging\Http\Controllers\Admin\CustomerController;
use Kodeingatan\Lodging\Http\Controllers\Admin\PaymentTransactionController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ReservationController;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomController;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomTypeController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ServiceController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ServiceUsageController;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomReservationController;

Route::middleware('web', 'auth', 'permission:admin')->prefix('/admin')->as('admin.')->group(function () {
    KiAdminRoute::makeCRUD(RoomTypeController::class, "/room_type", "room_type.");
    KiAdminRoute::makeCRUD(RoomController::class, "/room", "room.");
    KiAdminRoute::makeCRUD(ServiceController::class, "/additional_service", "additional_service.");
    KiAdminRoute::makeCRUD(CustomerController::class, "/customer", "customer.");
    KiAdminRoute::makeCRUD(ReservationController::class, "/reservation", "reservation.");
    KiAdminRoute::makeCRUD(ServiceUsageController::class, "/service_usage", "service_usage.");
    KiAdminRoute::makeCRUD(PaymentTransactionController::class, "/payment_transaction", "payment_transaction.");

    KiAdminRoute::makeCRUD(RoomReservationController::class, '/room_reservation', "room_reservation.");
});
