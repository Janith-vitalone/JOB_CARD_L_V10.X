<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('paymentCategories_id')->unsigned()->index();
            $table->foreign('paymentCategories_id')->references('id')->on('payment_categories');
            $table->string('bank')->nullable();
            $table->string('description', 500);
            $table->string('cheque_no')->nullable();
            $table->date('banking_date')->nullable();
            $table->float('amount',11,2);
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
        Schema::dropIfExists('other_payments');
    }
}
