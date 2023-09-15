<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobHasTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_has_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_id')->unsigned()->index();
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->string('description');
            $table->string('width');
            $table->string('height');
            $table->bigInteger('unit_id')->unsigned()->index();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('unit');
            $table->integer('copies');
            $table->bigInteger('printer_id')->unsigned()->index();
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->string('printer');
            $table->bigInteger('print_type_id')->unsigned()->index();
            $table->foreign('print_type_id')->references('id')->on('print_types');
            $table->string('print_type');
            $table->decimal('sqft_rate', 10, 2);
            $table->bigInteger('material_id')->unsigned()->index();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->string('materials');
            $table->bigInteger('lamination_id')->unsigned()->index();
            $table->foreign('lamination_id')->references('id')->on('laminations');
            $table->string('lamination');
            $table->decimal('lamination_rate', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->bigInteger('finishing_id')->unsigned()->index();
            $table->foreign('finishing_id')->references('id')->on('finishings');
            $table->decimal('finishing_rate', 10, 2);
            $table->string('finishing');
            $table->string('format');
            $table->enum('job_type', ['large_format', 'document']);
            $table->string('job_ss')->nullable();
            $table->bigInteger('format_id')->unsigned()->index();
            $table->foreign('format_id')->references('id')->on('formats')->onDelete('cascade');
            $table->string('product_id')->nullable();
            $table->string('product_category_id')->nullable();
            $table->string('stock_qty')->nullable();
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
        Schema::dropIfExists('job_has_tasks');
    }
}
