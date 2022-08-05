<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applocations', function (Blueprint $table) {
            $table->id();
            $table->string("kind_of_leave");
            $table->string("cause_of_leave");
            $table->date("start_date");
            $table->date("end_date");
            $table->string("no_of_days");
            $table->string("need_parmission");
            $table->string("in_charge");
            $table->string("accept_salary_difference")->nullable();
            $table->string("applied_by");
            $table->string("approved_by");
            $table->string("status");            
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
        Schema::dropIfExists('leave_applocations');
    }
}
