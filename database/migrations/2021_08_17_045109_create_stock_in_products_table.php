<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_in_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_in_id')->unsigned()->index();
            $table->foreign('stock_in_id')->references('id')->on('stock_ins');
            $table->integer('stock_product_category_id')->unsigned()->index();
            $table->foreign('stock_product_category_id')->references('id')->on('stock_product_categories');
            $table->bigInteger('supplier_product_id')->unsigned()->index();
            $table->foreign('supplier_product_id')->references('id')->on('supplier_products');
            $table->integer('qty');
            $table->decimal('unit_price', 10,2);
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
        Schema::dropIfExists('stock_in_products');
    }
}
