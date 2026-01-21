<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Backfill vendor_id for vehicles based on their creator's vendor_id.
     */
    public function up(): void
    {
        // Update vehicles that have NULL vendor_id by setting it to their creator's vendor_id
        DB::statement('
            UPDATE vehicles
            INNER JOIN users ON vehicles.created_by = users.id
            SET vehicles.vendor_id = users.vendor_id
            WHERE vehicles.vendor_id IS NULL
            AND users.vendor_id IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be safely reversed as we don't know
        // which vehicles originally had NULL vendor_id
    }
};
