<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stock_product_category_id')->unsigned()->index();
            $table->foreign('stock_product_category_id')->references('id')->on('stock_product_categories');
            $table->bigInteger('supplier_product_id')->unsigned()->index();
            $table->foreign('supplier_product_id')->references('id')->on('supplier_products');
            $table->integer('qty');
            $table->integer('reorder_level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
