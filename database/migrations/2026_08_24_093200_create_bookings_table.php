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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('name', 150);
        $table->string('email');
        $table->string('phone', 30)->nullable();
        $table->date('visit_date');
        $table->time('visit_time');
        $table->unsignedTinyInteger('guests');
        $table->text('message')->nullable();
        $table->string('status', 20)->default('pending');
        $table->timestamps();

        $table->index(['visit_date', 'status']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
