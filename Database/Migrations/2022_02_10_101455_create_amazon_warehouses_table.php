<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_warehouses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->string('name', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->string('street_1', 255)->nullable();
            $table->string('street_2', 255)->nullable();
            $table->string('postcode', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->boolean('default_warehouse')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_from', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_warehouses');
    }
}
