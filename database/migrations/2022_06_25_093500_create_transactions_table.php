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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount');
            $table->double('lilha_pay')->nullable();
            $table->unsignedBigInteger('fund_id');
            $table->unsignedBigInteger('sub_fund_id');
            $table->string('type')->comment('Credit or Debit');
            $table->string('trans_type')->comment('bank,cod,lilha');
            $table->string('account_no')->nullable();
            $table->string('scholarship')->nullable();
            $table->string('scholarship_type')->nullable();
            $table->integer('user_id');
            $table->integer('received_by');
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
        Schema::dropIfExists('transactions');
    }
};
