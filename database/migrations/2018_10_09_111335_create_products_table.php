<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('sku',45)->nullable();
            $table->string('short_description',100)->nullable();
            $table->text('long_description')->nullable();
            $table->float('price',14,2)->nullable();
            $table->float('special_price',14,2)->nullable();
            $table->date('special_price_from')->nullable();
            $table->date('special_price_to')->nullable();
            $table->enum('status',['1','0'])->default('0');
            $table->integer('quantity')->nullable();
            $table->string('meta_title',45);
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('modified_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
