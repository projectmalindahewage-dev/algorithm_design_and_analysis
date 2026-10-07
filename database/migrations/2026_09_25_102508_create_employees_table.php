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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_no');
            $table->string('first_name', 20);
            $table->string('last_name', 20)->nullable();
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('employees');
    }
};