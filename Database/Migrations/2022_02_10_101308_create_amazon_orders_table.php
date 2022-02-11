<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->nullable();
            $table->text('asin_ids')->nullable();
            $table->text('item_ids')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('items_shipped')->nullable();
            $table->integer('items_unshipped');
            $table->integer('company_id')->nullable();
            $table->string('country', 255)->nullable();
            $table->decimal('order_total', 10)->nullable();
            $table->string('currency_code', 255)->nullable();
            $table->string('fulfillment_channel', 255)->nullable();
            $table->text('payment_method')->nullable();
            $table->string('marketplace', 255)->nullable();
            $table->string('amazon_order_id', 255)->nullable();
            $table->dateTime('earliest_ship_date')->nullable();
            $table->dateTime('latest_delivery_date')->nullable();
            $table->dateTime('last_update_date')->nullable();
            $table->boolean('is_business_order')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->string('order_status', 255)->nullable();
            $table->string('tracking_id_1', 399)->nullable();
            $table->string('tracking_id_2', 399)->nullable();
            $table->string('tracking_id_3', 399)->nullable();
            $table->string('tracking_id_4', 399)->nullable();
            $table->string('tracking_id_5', 399)->nullable();
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
        Schema::dropIfExists('amazon_orders');
    }
}
