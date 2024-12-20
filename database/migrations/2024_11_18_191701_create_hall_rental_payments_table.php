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
        Schema::create('hall_rental_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_rental_id');
            $table->foreign('hall_rental_id')->references('id')->on('hall_rentals')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('date');
            $table->enum('payment_method', ['cash', 'bank'])->default('cash');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transaction_id')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_rental_payments');
    }
};
