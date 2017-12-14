<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoolToKeywordProjectTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('keyword_project');

		Schema::create(
			'keyword_project',
			function (Blueprint $table) {
				$table->integer('keyword_id')->references('id')->on('keywords')->onDelete('cascade')->index();
				$table->integer('project_id')->references('id')->on('projects')->onDelete('cascade')->index();
				$table->boolean('accepted')->nullable();
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('keyword_project');
	}
}
