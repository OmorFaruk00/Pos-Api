<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->bigInteger('opening_quantity')->default('0');
            $table->bigInteger('available_quantity')->default('0');
            $table->bigInteger('purchased_quantity')->default('0');
            $table->bigInteger('sold_quantity')->default('0');
            $table->bigInteger('wastage_quantity')->default('0');
            $table->bigInteger('transfer_in')->default('0');
            $table->bigInteger('transfer_out')->default('0');
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
        Schema::dropIfExists('product_stocks');
    }
}
