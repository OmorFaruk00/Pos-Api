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
            $table->integer('student_id');
            $table->integer('class_id')->nullable();
            $table->string('fee_type');
            $table->integer('month_count')->nullable();
            $table->double('amount');
            $table->string('scholarship')->nullable();
            $table->integer('transaction_id');
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
