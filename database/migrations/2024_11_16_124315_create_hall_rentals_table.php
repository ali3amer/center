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
            $table->string('name');
            $table->enum("type", ['organization', 'government_institution', 'prison'])->default('organization');
            $table->enum('days',['day', 'hour'])->default(1);
            $table->decimal('price', 8, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
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
