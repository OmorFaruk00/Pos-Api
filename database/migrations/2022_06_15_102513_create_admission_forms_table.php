<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_number')->nullable();
            $table->string('name_of_student')->nullable();
            $table->string('dept_id')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('roll')->nullable();
            $table->string('reg_code')->nullable();
            $table->date('sale_date')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('sale_by')->nullable();
            $table->string('admission_by')->nullable();
            $table->string('created_by')->nullable();            
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
        Schema::dropIfExists('admission_forms');
    }
}
