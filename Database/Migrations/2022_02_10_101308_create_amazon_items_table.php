<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id')->nullable();
            $table->string('country', 255)->nullable();
            $table->integer('warehouse')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->binary('title')->nullable();
            $table->string('product_type', 255)->nullable();
            $table->string('weight_measure', 999)->nullable();
            $table->string('country_of_origin', 255)->nullable();
            $table->string('brand', 555)->nullable();
            $table->text('keywords')->nullable();
            $table->string('enable', 255)->nullable();
            $table->string('amazon_status', 255)->nullable();
            $table->string('ean', 255)->nullable();
            $table->integer('packaging')->nullable();
            $table->string('asin', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('size', 255)->nullable();
            $table->string('height', 255)->nullable();
            $table->string('length', 255)->nullable();
            $table->string('length_measure', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('width', 255)->nullable();
            $table->string('width_measure', 255)->nullable();
            $table->string('height_measure', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->string('material', 500)->nullable();
            $table->double('sale_price', 15, 4)->nullable();
            $table->date('sale_start_date')->nullable();
            $table->date('sale_end_date')->nullable();
            $table->double('price', 15, 4)->nullable();
            $table->string('currency_code', 255)->nullable()->default('GBP');
            $table->binary('description')->nullable();
            $table->integer('lead_time_to_ship_max_days')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->mediumText('main_picture')->nullable();
            $table->mediumText('picture_1')->nullable();
            $table->mediumText('picture_2')->nullable();
            $table->mediumText('picture_3')->nullable();
            $table->mediumText('picture_4')->nullable();
            $table->mediumText('picture_5')->nullable();
            $table->mediumText('picture_6')->nullable();
            $table->mediumText('picture_7')->nullable();
            $table->mediumText('bullet_point_1')->nullable();
            $table->mediumText('bullet_point_2')->nullable();
            $table->mediumText('bullet_point_3')->nullable();
            $table->mediumText('bullet_point_4')->nullable();
            $table->mediumText('bullet_point_5')->nullable();
            $table->mediumText('bullet_point_6')->nullable();
            $table->boolean('is_uploaded_uk')->default(false);
            $table->boolean('is_uploaded_de')->default(false);
            $table->boolean('is_uploaded_fr')->default(false);
            $table->boolean('is_uploaded_it')->default(false);
            $table->boolean('is_uploaded_es')->default(false);
            $table->boolean('is_uploaded_se')->default(false);
            $table->boolean('is_uploaded_nl')->default(false);
            $table->boolean('is_uploaded_pl')->default(false);
            $table->boolean('is_uploaded_us')->default(false);
            $table->boolean('is_uploaded_ca')->default(false);
            $table->tinyInteger('otherseller_warning')->nullable();
            $table->integer('createad_by')->nullable();
            $table->string('created_from', 255)->nullable();
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
        Schema::dropIfExists('amazon_items');
    }
}
