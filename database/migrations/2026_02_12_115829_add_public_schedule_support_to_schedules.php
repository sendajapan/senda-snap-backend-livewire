<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('comment');
            $table->string('added_by_name')->nullable()->after('is_public');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropForeign(['added_by']);
            });
            DB::statement('ALTER TABLE schedules MODIFY added_by BIGINT UNSIGNED NULL');
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreign('added_by')->references('id')->on('users')->nullOnDelete();
            });
        }

        Schema::table('schedule_stopovers', function (Blueprint $table) {
            $table->string('added_by_name')->nullable()->after('port_id');
        });

        if ($driver === 'mysql') {
            Schema::table('schedule_stopovers', function (Blueprint $table) {
                $table->dropForeign(['added_by']);
            });
            DB::statement('ALTER TABLE schedule_stopovers MODIFY added_by BIGINT UNSIGNED NULL');
            Schema::table('schedule_stopovers', function (Blueprint $table) {
                $table->foreign('added_by')->references('id')->on('users')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('schedule_stopovers', function (Blueprint $table) {
                $table->dropForeign(['added_by']);
            });
            DB::statement('ALTER TABLE schedule_stopovers MODIFY added_by BIGINT UNSIGNED NOT NULL');
            Schema::table('schedule_stopovers', function (Blueprint $table) {
                $table->foreign('added_by')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        Schema::table('schedule_stopovers', function (Blueprint $table) {
            $table->dropColumn('added_by_name');
        });

        if ($driver === 'mysql') {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropForeign(['added_by']);
            });
            DB::statement('ALTER TABLE schedules MODIFY added_by BIGINT UNSIGNED NOT NULL');
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreign('added_by')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'added_by_name']);
        });
    }
};
