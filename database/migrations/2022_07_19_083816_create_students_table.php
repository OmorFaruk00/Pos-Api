<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('NAME')->nullable();
            $table->string('ROLL_NO')->nullable();
            $table->string('REG_CODE')->nullable();
            $table->string('DEPARTMENT_ID')->nullable();
            $table->string('BATCH_ID')->nullable();
            $table->string('SHIFT_ID')->nullable();
            $table->string('EMAIL')->nullable();
            $table->string('YEAR')->nullable();
            $table->string('REG_SL_NO')->nullable();
            $table->string('GROUP_ID')->nullable();
            $table->string('BLOOD_GROUP')->nullable();
            $table->string('PHONE_NO')->nullable();
            $table->string('ADM_FRM_SL')->nullable();
            $table->string('RELIGION')->nullable();
            $table->string('GENDER')->nullable();
            $table->string('DOB')->nullable();
            $table->string('BIRTH_PLACE')->nullable();
            $table->string('FG_MONTHLY_INCOME')->nullable();
            $table->text('PARMANENT_ADD')->nullable();
            $table->text('MAILING_ADD')->nullable();
            $table->string('F_NAME')->nullable();
            $table->string('F_CELLNO')->nullable();
            $table->string('F_OCCU')->nullable();
            $table->string('M_NAME')->nullable();
            $table->string('M_CELLNO')->nullable();
            $table->string('M_OCCU')->nullable();
            $table->string('G_NAME')->nullable();
            $table->string('G_CELLNO')->nullable();
            $table->string('G_OCCU')->nullable();
            $table->string('E_NAME')->nullable();
            $table->string('E_CELLNO')->nullable();
            $table->string('E_OCCU')->nullable();
            $table->string('E_RELATION')->nullable();
            $table->string('E_ADDRESS')->nullable();
            $table->string('NATIONALITY')->nullable();
            $table->string('MARITAL_STATUS')->nullable();
            $table->date('ADM_DATE')->nullable();
            $table->string('STD_BIRTH_OR_NID_NO')->nullable();
            $table->string('FATHER_NID_NO')->nullable();
            $table->string('MOTHER_NID_NO')->nullable();
            $table->string('PHOTO')->nullable();
            $table->string('SIGNATURE')->nullable();
            $table->string('ADMISSION_BY')->nullable();
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
        Schema::dropIfExists('students');
    }
}
