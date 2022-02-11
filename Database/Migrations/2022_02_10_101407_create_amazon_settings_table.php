<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->integer('default_warehouse')->nullable();
            $table->tinyInteger('de')->nullable();
            $table->tinyInteger('fr')->nullable();
            $table->tinyInteger('it')->nullable();
            $table->tinyInteger('es')->nullable();
            $table->tinyInteger('uk')->nullable();
            $table->tinyInteger('se')->nullable();
            $table->tinyInteger('nl')->nullable();
            $table->tinyInteger('pl')->nullable();
            $table->string('items_update_on_amazon_cron', 255)->nullable()->default('off');
            $table->string('items_update_on_amazon_cron_frequency', 255)->nullable();
            $table->string('orders_download_cron', 255)->nullable()->default('off');
            $table->string('orders_download_cron_frequency', 255)->nullable();
            $table->string('orders_update_cron', 255)->nullable()->default('off');
            $table->string('orders_update_cron_frequency', 255)->nullable();
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
        Schema::dropIfExists('amazon_settings');
    }
}
