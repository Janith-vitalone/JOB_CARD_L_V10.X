<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubstockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_id')->unsigned()->index();
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->integer('stock_product_category_id')->unsigned()->index();
            $table->foreign('stock_product_category_id')->references('id')->on('stock_product_categories');
            $table->bigInteger('supplier_product_id')->unsigned()->index();
            $table->foreign('supplier_product_id')->references('id')->on('supplier_products');
            $table->bigInteger('unit_id')->unsigned()->index();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->decimal('available_area', 10,4);
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
        Schema::dropIfExists('substock');
    }
}
