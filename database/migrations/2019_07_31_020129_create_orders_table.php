<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('currency');
            $table->integer('amount');
            $table->integer('state')->default(0);
            $table->integer('game_id');
            $table->integer('user_id');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('cp_order_id')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('callback_info')->nullable();
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
