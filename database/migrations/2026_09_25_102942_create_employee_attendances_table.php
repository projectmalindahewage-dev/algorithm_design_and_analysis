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
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_no');
            $table->dateTime('in_time')->nullable();
            $table->dateTime('out_time')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->boolean('formatted_status')->default(0)->comment("0=>not,1=>formatted");
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
        Schema::dropIfExists('employee_attendances');
    }
};