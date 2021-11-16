<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->integer('classify_voucher_id');
            $table->string('title');
            $table->string('code',191);
            $table->tinyInteger('sale');
            $table->string('user',255);
            $table->decimal('condition',10,0);
            $table->date('expiration');
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('times');
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
        Schema::dropIfExists('vouchers');
    }
}
