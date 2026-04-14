<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::dropIfExists('shipping_companies');
    }
};
