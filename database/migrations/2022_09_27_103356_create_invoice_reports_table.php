<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_reports', function (Blueprint $table) {
            $table->id();
            $table->integer("invoice_id");
            $table->string("product_name");
            $table->string("product_code");
            $table->string("product_qty");
            $table->string("product_price");
            $table->string("total_amount");
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
        Schema::dropIfExists('invoice_reports');
    }
}
