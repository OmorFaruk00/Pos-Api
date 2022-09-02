<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('email')->unique();
            $table->string('password', 200);             
            $table->string('designation_id');
            $table->string('department_id');            
            $table->string('personal_phone_no', 12);
            $table->string('alternative_phone_no', 12)->nullable();           
            $table->string('home_phone_no', 12)->nullable();            
            $table->enum('jobtype', ['Part Time', 'Full Time']);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_join')->nullable();            
            $table->string('nid_no', 20)->nullable();            
            $table->string('profile_photo', 100)->nullable();            
            $table->integer('status');           
            $table->text('permissions')->nullable();
            $table->string('role')->nullable();           
            $table->string('weekly_working_hours', 7)->nullable();           
            $table->string('created_by');
            $table->string('merit', 20)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
}
