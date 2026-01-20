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
        Schema::create('schedule_stopovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('port_id')->constrained('ports')->cascadeOnDelete();
            $table->dateTime('stopover_eta')->nullable();
            $table->dateTime('stopover_etd')->nullable();
            $table->enum('status', ['Waiting', 'Loading', 'On-Sea', 'Stop Over', 'Destination'])->default('Waiting');
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_stopovers');
    }
};
