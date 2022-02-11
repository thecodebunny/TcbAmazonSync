<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_issues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('item_id');
            $table->integer('amz_item_id');
            $table->string('code', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('severity', 255)->nullable();
            $table->mediumText('attribute_names')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
        Schema::dropIfExists('amazon_issues');
    }
}
