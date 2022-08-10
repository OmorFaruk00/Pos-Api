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
            $table->double('amount');
            $table->integer('fund_id');
            $table->integer('sub_fund_id');
            $table->string('type')->comment('Credit or Debit');
            $table->integer('user_id')->comment('pay to who');
            $table->integer('received_by')->comment('received by who');
            $table->double('lilha_pay')->nullable();
            $table->string('trans_type')->comment('bank,cod,lilha');
            $table->string('account_no')->nullable();
            $table->string('scholarship')->nullable();
            $table->string('scholarship_type')->nullable();
            $table->morphs('transactionable');
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
