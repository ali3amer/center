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
        Schema::create('hall_rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id');
            $table->foreign('hall_id')->references('id')->on('halls')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->enum("type", ['organization', 'government_institution', 'prison'])->default('organization');
            $table->enum('duration_type',['day', 'hour'])->default('day');
            $table->float('duration', 8, 2)->default(0);
            $table->decimal('price', 8, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_rentals');
    }
};
