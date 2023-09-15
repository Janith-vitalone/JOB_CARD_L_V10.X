<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_id')->unsigned()->index();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->decimal('paid_amount', 10, 2);
            $table->enum('payment_type', ['cash', 'cc', 'cheque']);
            $table->string('cheque_no')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->date('cheque_date')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
