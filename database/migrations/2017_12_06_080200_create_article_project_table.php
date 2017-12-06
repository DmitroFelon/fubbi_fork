<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('article_project');

        Schema::create('article_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->index();
            $table->integer('project_id')->index();
            $table->boolean('accepted')->nullable();
            $table->smallInteger('attempts')->nullable();
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
        Schema::dropIfExists('article_project');
    }
}
