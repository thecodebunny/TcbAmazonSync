<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('root_node')->nullable();
            $table->text('uk_node_id')->nullable();
            $table->text('node_path')->nullable();
            $table->text('de_node_id')->nullable();
            $table->text('fr_node_id')->nullable();
            $table->text('it_node_id')->nullable();
            $table->text('es_node_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('amazon_categories');
    }
}
