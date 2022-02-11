<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_brands', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->boolean('enabled')->default(false);
            $table->boolean('default_brand')->default(false);
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
        Schema::dropIfExists('amazon_brands');
    }
}
