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
        Schema::create('formatted_attendance_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('formatted_attendance_id');
            $table->bigInteger('attendance_referance_id');
            $table->date('in_date');
            $table->time('in_time');
            $table->date('out_date');
            $table->time('out_time');
            $table->integer('shift_id')->nullable();
            $table->integer('roster_id')->nullable();
            $table->boolean('status')->default(1)->comment("1=>active,0=>deactivate");
            $table->bigInteger('added_by')->nullable();
            $table->timestamp('added_date')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formatted_attendance_details');
    }
};
