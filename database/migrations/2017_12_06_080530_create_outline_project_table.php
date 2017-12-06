<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutlineProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('outline_project');
        
        Schema::create('outline_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('outline_id')->index();
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
        Schema::dropIfExists('outline_project');
    }
}
