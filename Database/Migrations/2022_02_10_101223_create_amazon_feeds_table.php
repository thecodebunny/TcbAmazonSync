<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_feeds', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('country', 255)->nullable();
            $table->string('feed_id', 255)->nullable();
            $table->string('feed_type', 499);
            $table->longText('url')->nullable();
            $table->longText('feed_document_id')->nullable();
            $table->mediumText('result_feed_document_id')->nullable();
            $table->longText('result_feed_url')->nullable();
            $table->text('report_type')->nullable();
            $table->string('api_type', 255);
            $table->text('request_id')->nullable();
            $table->text('generated_report_id')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('created_from')->nullable();
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
        Schema::dropIfExists('amazon_feeds');
    }
}
