<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_product_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 999)->nullable();
            $table->boolean('is_uk')->default(false);
            $table->boolean('is_de')->default(false);
            $table->boolean('is_fr')->default(false);
            $table->boolean('is_it')->default(false);
            $table->boolean('is_es')->default(false);
            $table->boolean('is_se')->default(false);
            $table->boolean('is_nl')->default(false);
            $table->boolean('is_pl')->default(false);
            $table->boolean('is_us')->default(false);
            $table->boolean('is_ca')->default(false);
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
        Schema::dropIfExists('amazon_product_types');
    }
}
