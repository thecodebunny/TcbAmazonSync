<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonSpApiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_sp_api_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->string('seller_id', 255)->nullable();
            $table->text('app_name')->nullable();
            $table->text('app_id')->nullable();
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->text('eu_token')->nullable();
            $table->text('us_token')->nullable();
            $table->text('ias_access_key')->nullable();
            $table->text('ias_access_token')->nullable();
            $table->text('endpoint')->nullable();
            $table->text('iam_arn')->nullable();
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
        Schema::dropIfExists('amazon_sp_api_settings');
    }
}
