<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('room_id');

            $table->date('checkin_date');
            $table->date('checkout_date');

            $table->string('status')->default('in_process');
            $table->string('payment_status')->default('in_process');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasions');
    }
};
