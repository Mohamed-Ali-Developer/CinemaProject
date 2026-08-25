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
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_time_id')
                ->constrained('show_times')
                ->cascadeOnDelete();
            $table->string('seat_type');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->unique(['show_time_id', 'seat_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};
