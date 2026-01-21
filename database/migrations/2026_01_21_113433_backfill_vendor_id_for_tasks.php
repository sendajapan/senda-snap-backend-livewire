<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Backfill vendor_id for tasks based on their creator's vendor_id.
     */
    public function up(): void
    {
        // Update tasks that have NULL vendor_id by setting it to their creator's vendor_id
        DB::statement('
            UPDATE tasks
            INNER JOIN users ON tasks.created_by = users.id
            SET tasks.vendor_id = users.vendor_id
            WHERE tasks.vendor_id IS NULL
            AND users.vendor_id IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be safely reversed as we don't know
        // which tasks originally had NULL vendor_id
        // If needed, you can manually set vendor_id back to NULL for specific tasks
    }
};
