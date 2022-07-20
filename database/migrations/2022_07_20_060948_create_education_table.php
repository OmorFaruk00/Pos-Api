<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('student_reg_code');
            $table->string('exam_name1')->nullable();
            $table->string('group1')->nullable();
            $table->string('roll_no1')->nullable();
            $table->date('passing_year1')->nullable();
            $table->string('ltr_grd_tmarks1')->nullable();
            $table->string('div_cls_cgpa1')->nullable();
            $table->string('board_institute1')->nullable();

            $table->string('exam_name2')->nullable();
            $table->string('group2')->nullable();
            $table->string('roll_no2')->nullable();
            $table->date('passing_year2')->nullable();
            $table->string('ltr_grd_tmarks2')->nullable();
            $table->string('div_cls_cgpa2')->nullable();
            $table->string('board_institute2')->nullable();

            $table->string('exam_name3')->nullable();
            $table->string('group3')->nullable();
            $table->string('roll_no3')->nullable();
            $table->date('passing_year3')->nullable();
            $table->string('ltr_grd_tmarks3')->nullable();
            $table->string('div_cls_cgpa3')->nullable();
            $table->string('board_institute3')->nullable();

            $table->string('exam_name4')->nullable();
            $table->string('group4')->nullable();
            $table->string('roll_no4')->nullable();
            $table->date('passing_year4')->nullable();
            $table->string('ltr_grd_tmarks4')->nullable();
            $table->string('div_cls_cgpa4')->nullable();
            $table->string('board_institute4')->nullable();
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
        Schema::dropIfExists('education');
    }
}
