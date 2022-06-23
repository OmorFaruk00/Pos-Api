<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id('id');
            $table->string('committee_type');                     
            $table->string('member_type');                     
            $table->string('member_name');                     
            $table->string('profession');                      
            $table->string('personal_phone_no', 12);
            $table->string('alternative_phone_no', 12)->nullable();           
            $table->string('home_phone_no', 12)->nullable();            
            $table->date('date_of_birth')->nullable();                     
            $table->string('nid_no', 20)->nullable();            
            $table->string('image', 100)->nullable();            
            $table->string('status');          
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
        Schema::dropIfExists('committees');
    }
}
