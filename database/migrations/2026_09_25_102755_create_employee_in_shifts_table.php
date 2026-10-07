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
        Schema::create('employee_in_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('department_id');
            $table->integer('employee_id');
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
        Schema::dropIfExists('employee_in_shifts');
    }
};
