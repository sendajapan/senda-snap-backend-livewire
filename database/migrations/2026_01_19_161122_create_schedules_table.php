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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('vessel_name');
            $table->string('voyage_no');
            $table->foreignId('carrier_1_id')->nullable()->constrained('shipping_companies')->nullOnDelete();
            $table->foreignId('carrier_2_id')->nullable()->constrained('shipping_companies')->nullOnDelete();
            $table->foreignId('carrier_3_id')->nullable()->constrained('shipping_companies')->nullOnDelete();
            $table->foreignId('start_port_id')->constrained('ports')->cascadeOnDelete();
            $table->foreignId('end_port_id')->constrained('ports')->cascadeOnDelete();
            $table->string('eta');
            $table->enum('status', ['Waiting', 'Loading', 'On-Sea', 'Stop Over', 'Destination'])->default('Waiting');
            $table->text('comment')->nullable();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
