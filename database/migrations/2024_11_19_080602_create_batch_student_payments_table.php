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
        Schema::create('batch_student_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_student_id');
            $table->foreign('batch_student_id')->references('id')->on('batch_students')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount', 8, 2)->default(0);
            $table->date('date');
            $table->enum('payment_method', ['cash', 'bank'])->default('cash');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_student_payments');
    }
};
