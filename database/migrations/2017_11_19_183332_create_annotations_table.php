<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('article_id')->index();
            $table->integer('user_id');
            $table->text('text')->nullable();
            $table->text('quote')->nullable();
            $table->text('permissions')->nullable();
            $table->text('tags')->nullable();
            $table->text('ranges');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annotations');
    }
}
