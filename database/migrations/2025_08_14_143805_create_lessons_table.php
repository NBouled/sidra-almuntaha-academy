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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->dateTime('starts_at'); // geplande starttijd
            $table->dateTime('ends_at');   // geplande eindtijd
            $table->string('status')->default('scheduled');
            $table->integer('duration_minutes')->default(55); // duur in minuten

            $table->string('zoom_meeting_id')->nullable();
            $table->string('zoom_meeting_link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
