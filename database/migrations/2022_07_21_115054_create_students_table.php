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
            $table->string('student_name')->nullable();
            $table->string('roll_no')->nullable();
            $table->string('reg_code')->nullable();
            $table->string('department_id')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('shift_id')->nullable();
            $table->string('email')->nullable();
            $table->string('year')->nullable();
            $table->string('reg_sl_no')->nullable();
            $table->string('group_id')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('adm_frm_sl')->nullable();
            $table->string('religion_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('fg_monthly_income')->nullable();
            $table->text('permanent_add')->nullable();
            $table->text('mailing_add')->nullable();
            $table->string('f_name')->nullable();
            $table->string('f_cellno')->nullable();
            $table->string('f_occu')->nullable();
            $table->string('m_name')->nullable();
            $table->string('m_cellno')->nullable();
            $table->string('m_occu')->nullable();
            $table->string('g_name')->nullable();
            $table->string('g_cellno')->nullable();
            $table->string('g_occu')->nullable();
            $table->string('e_name')->nullable();
            $table->string('e_cellno')->nullable();
            $table->string('e_occu')->nullable();
            $table->string('e_relation')->nullable();
            $table->string('e_address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('adm_date')->nullable();
            $table->string('std_birth_or_nid_no')->nullable();
            $table->string('father_nid_no')->nullable();
            $table->string('mother_nid_no')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('admission_by')->nullable();
            $table->string('refereed_by')->nullable();
            $table->string('refereed_by_email')->nullable();            
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
