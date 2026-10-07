<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // The supplied production SQL dump uses MyISAM, which ignores transactions
        // and cannot participate in the foreign key below. Convert the write path.
        if (DB::connection()->getDriverName() === 'mysql') {
            foreach (['employee_attendances', 'formatted_attendances', 'formatted_attendance_details'] as $table) {
                DB::statement("ALTER TABLE `{$table}` ENGINE=InnoDB");
            }
        }

        Schema::create('formatted_attendance_detail_sources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formatted_attendance_detail_id');
            $table->unsignedBigInteger('employee_attendance_id');
            $table->timestamps();
            $table->unique(['formatted_attendance_detail_id', 'employee_attendance_id'], 'formatted_detail_source_unique');
            $table->index('employee_attendance_id', 'fmt_detail_source_attendance_idx');
            $table->foreign('formatted_attendance_detail_id', 'fmt_detail_source_detail_fk')
                ->references('id')->on('formatted_attendance_details')->cascadeOnDelete();
        });

        // Preserve the one-to-one source references created before this table existed.
        DB::table('formatted_attendance_details')
            ->select('id', 'attendance_referance_id')
            ->whereNotNull('attendance_referance_id')
            ->orderBy('id')
            ->chunkById(500, function ($details): void {
                $now = now();
                $links = $details->map(fn ($detail) => [
                    'formatted_attendance_detail_id' => $detail->id,
                    'employee_attendance_id' => $detail->attendance_referance_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all();

                DB::table('formatted_attendance_detail_sources')->insertOrIgnore($links);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('formatted_attendance_detail_sources');
    }
};
