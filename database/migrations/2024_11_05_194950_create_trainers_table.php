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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('arabic_name');
            $table->string('english_name')->nullable();
            $table->string("national_id")->nullable();
            $table->enum("gender", ['male', 'female'])->default('male');
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("address")->nullable();
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
