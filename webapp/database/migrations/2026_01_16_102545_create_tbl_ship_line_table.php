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
        // Drop old shipping_companies table
        Schema::dropIfExists('shipping_companies');

        // Create new tbl_ship_line table
        Schema::create('tbl_ship_line', function (Blueprint $table) {
            $table->id();
            $table->string('line_name');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_ship_line');

        // Recreate old shipping_companies table structure if needed
        Schema::create('shipping_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->enum('company_type', ['Transporter', 'Shipping Line', 'Workshop', 'PROVIDER', 'EXPENSE', 'COURIER']);
            $table->enum('company_status', ['Active', 'Inactive'])->default('Active');
            $table->string('company_name_jp')->nullable();
            $table->integer('per_m3')->nullable();
            $table->integer('per_container')->nullable();
            $table->string('zip')->nullable();
            $table->string('country_name')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
};
