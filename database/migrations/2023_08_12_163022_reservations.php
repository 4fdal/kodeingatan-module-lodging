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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();

            $table->integer('total_stay_days')->default(1);

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
        Schema::dropIfExists('reservations');
    }
};
