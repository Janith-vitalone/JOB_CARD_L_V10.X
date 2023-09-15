<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationHasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_has_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_id')->unsigned()->index();
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->string('description');
            $table->string('sub_description', 255);
            $table->decimal('unit_price', 10, 2);
            $table->integer('qty');
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('quotation_has_items');
    }
}
