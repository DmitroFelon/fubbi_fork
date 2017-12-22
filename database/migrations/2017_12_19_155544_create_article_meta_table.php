<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasTable('article_meta')){
            return;
        }
        
        Schema::create('article_meta', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('article_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->string('type')->default('null');
            $table->string('key')->index();
            $table->text('value')->nullable();

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
        Schema::dropIfExists('article_meta');
    }
}
