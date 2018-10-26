<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('billing_address_id')->unsigned()->nullable();
            $table->integer('shipping_address_id')->unsigned()->nullable();
            $table->string('AWB_NO',100);
            $table->integer('payment_gateway_id');
            $table->string('transaction_id')->nullable();
            $table->enum('status',['pending','processing','dispatched','delivered','cancelled'])->default('pending');
            $table->float('grand_total',12,2);
            $table->float('shipping_charges',12,2);
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('billing_address_id')->references('id')->on('user_address')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('shipping_address_id')->references('id')->on('user_address')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onUpdate('cascade')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_order');
    }
}
