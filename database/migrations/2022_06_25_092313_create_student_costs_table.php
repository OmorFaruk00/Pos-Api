<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('batch_id')->nullable();
            $table->integer('student_id');
            $table->integer('fee_type')->comment('purpose id');
            $table->integer('month_count')->nullable();
            $table->double('amount');
            $table->string('scholarship')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_costs');
    }
};
