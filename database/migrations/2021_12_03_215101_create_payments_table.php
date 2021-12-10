<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('paymentID')->unique();
            $table->integer('transID')->unique();
            $table->decimal('amount',16,0);
            $table->decimal('resultCode',12,0);
            $table->string('message',255);
            $table->string('payType')->nullable();
            $table->string('orderInfo')->nullable();
            $table->string('requestType')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
