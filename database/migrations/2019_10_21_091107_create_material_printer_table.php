<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialPrinterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_printer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('printer_id')->unsigned();
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->bigInteger('material_id')->unsigned();
            $table->foreign('material_id')->references('id')->on('materials');
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
        Schema::dropIfExists('material_printer');
    }
}
