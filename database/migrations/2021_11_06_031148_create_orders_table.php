<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('voucher_id')->nullable();
            $table->integer('shipper_id')->nullable();
            $table->tinyInteger('process_id')->default(1);
            $table->string('code_orders');
            $table->decimal('total_price', 15, 0);
            $table->string('customer_name', 255);
            $table->string('customer_phone', 20);
            $table->text('customer_address');
            $table->text('customer_note')->nullable();
            $table->decimal('transportation_costs', 10, 0);
            $table->tinyInteger('payments');
            $table->tinyInteger('shop_confirm')->nullable();
            $table->tinyInteger('shipper_confirm')->nullable();
            $table->text('shop_note')->nullable();
            $table->text('cancel_note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
