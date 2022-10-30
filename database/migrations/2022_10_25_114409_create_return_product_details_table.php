<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_product_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('product_return_id');
            $table->string('name');
            $table->string('code');
            $table->string('qty');
            $table->string('price');
            $table->string('amount');
            $table->string('discount');
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
        Schema::dropIfExists('return_product_details');
    }
}
