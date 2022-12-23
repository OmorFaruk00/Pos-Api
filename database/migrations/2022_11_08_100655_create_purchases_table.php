<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer("supplier_id");
            $table->string("vat")->nullable();
            $table->string("discount_amount")->nullable();
            $table->string("subtotal_amount");
            $table->string("payable_amount");
            $table->string("paid_amount");
            $table->string("due_amount")->nullable();
            $table->date("purchase_date");
            $table->string("created_by");
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
        Schema::dropIfExists('purchases');
    }
}
