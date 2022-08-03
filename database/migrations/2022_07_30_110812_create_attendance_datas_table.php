<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_datas', function (Blueprint $table) {
            $table->id();
            $table->string('attendnce_by_id');
            $table->date('date');
            $table->timestamp('time');
            $table->string('department_id');           
            $table->string('department_name');           
            $table->string('batch_id');
            $table->string('course_id');
            $table->string('course_name');
            $table->string('course_code');
            $table->string('status')->nullable();      
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
        Schema::dropIfExists('attendance_datas');
    }
}
