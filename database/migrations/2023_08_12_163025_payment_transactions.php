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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->unsignedBigInteger('reservation_id');

            $table->date('transaction_date');
            $table->string('payment_method')->nullable();

            $table->double('total_cost')->nullable();
            $table->double('tax')->nullable();
            $table->double('total_bill')->nullable();

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('reservation_id')->references('id')->on('reservasions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
