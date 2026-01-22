<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the vendors table for multi-vendor support.
     * Each vendor has their own external vehicle database configuration.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // External vehicle database connection credentials (required, not null)
            $table->string('external_db_host');
            $table->string('external_db_port')->default('3306');
            $table->string('external_db_database');
            $table->string('external_db_username');
            $table->text('external_db_password'); // Encrypted

            // Image path and base URL configuration (required, not null)
            $table->string('external_image_path');
            $table->string('external_image_base_url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
