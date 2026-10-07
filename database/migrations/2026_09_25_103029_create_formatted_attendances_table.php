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
        Schema::create('formatted_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->date('date');
            $table->string('day');
            $table->bigInteger('total_work_time')->nullable();
            $table->tinyInteger('weekend')->default('0')->comment("0=> day,1=>weekend");
            $table->tinyInteger('holiday')->default('0')->comment("0=>Not,1=>half,2=>full");
            $table->tinyInteger('off')->default('0')->comment("0=>Not,1=>half,2=>full");
            $table->tinyInteger('leave')->default('0')->comment("0=>Not,1=>half,2=>full");
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
        Schema::dropIfExists('formatted_attendances');
    }
};
