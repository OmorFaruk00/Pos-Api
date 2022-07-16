<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_purposes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount');
            $table->integer('class_id');
            $table->integer('month_wise')->default(0)->comment('0 for one time payment, 1 for monthly wise');
            $table->integer('fund_id');
            $table->integer('sub_fund_id');
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
        Schema::dropIfExists('payment_purposes');
    }
};
