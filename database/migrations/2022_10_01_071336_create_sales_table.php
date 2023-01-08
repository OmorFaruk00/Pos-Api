<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id");
            $table->string("vat")->nullable();
            $table->string("discount_amount")->nullable();
            $table->string("subtotal_amount");
            $table->string("payable_amount");
            $table->string("paid_amount");
            $table->string("due_amount")->nullable();
            $table->string("created_by");
            $table->date("sale_date");
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
        Schema::dropIfExists('sales');
    }
}
