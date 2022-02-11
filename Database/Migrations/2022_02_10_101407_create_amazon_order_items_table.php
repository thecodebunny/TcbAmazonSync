<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_order_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id')->nullable();
            $table->string('asin', 255)->nullable();
            $table->integer('amazon_item_id')->nullable();
            $table->text('image')->nullable();
            $table->string('sku', 999)->nullable();
            $table->integer('item_id')->nullable();
            $table->string('country', 255)->nullable();
            $table->integer('order_id')->nullable();
            $table->string('amazon_order_id', 255)->nullable();
            $table->string('amazon_order_item_id', 255)->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price', 15, 4)->nullable();
            $table->integer('item_tax')->nullable();
            $table->double('currency_code', 15, 4)->nullable();
            $table->double('promotion_discount', 15, 4)->nullable();
            $table->double('promotion_discount_tax', 15, 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_order_items');
    }
}
