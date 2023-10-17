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
        Schema::create('service_usages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->unsignedBigInteger('additional_service_id');
            $table->unsignedBigInteger('reservation_id');

            $table->integer('number_of_uses')->default(1);
            $table->double('total_service_cost');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('additional_service_id')->references('id')->on('additional_services');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_usages');
    }
};
