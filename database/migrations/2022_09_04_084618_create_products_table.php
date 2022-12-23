<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->unique()->nullable();
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('unit')->nullable();                   
            $table->decimal('purchase_price', 10, 2)->default('0.00');            
            $table->decimal('sales_price', 10, 2)->default('0.00');
            $table->integer('tax')->nullable()->default(0);
            $table->integer('opening_qty')->nullable()->default(0);
            $table->integer('alert_qty')->default('0');
            $table->string('barcode')->unique()->nullable();
            $table->string('warranty')->nullable();
            $table->string('guarantee')->nullable();            
            $table->string('image')->nullable();
            $table->string('discount')->nullable();
            $table->text('description')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('products');
    }
}
