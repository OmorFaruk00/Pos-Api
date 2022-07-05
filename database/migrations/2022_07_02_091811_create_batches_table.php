<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name');
            $table->string('department_id');
            $table->string('group')->nullable();
            $table->string('shift')->nullable();
            $table->string('said_fee')->nullable();
            $table->string('common_scholarship')->nullable();
            $table->string('no_of_seat');
            $table->string('year')->nullable();
            $table->string('session')->nullable();
            $table->string('admission_season')->nullable();
            $table->date('id_card_expiration_date')->nullable();
            $table->date('class_start_date')->nullable();
            $table->date('last_data_of_admission')->nullable();
            $table->date('admission_start_date')->nullable();
            $table->date('duration')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('batches');
    }
}
