<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id');
			$table->string('state');
			$table->string('name');
			$table->string('themes', 400)->nullable();
			$table->string('questions', 400)->nullable();
			$table->string('relevance', 400)->nullable();
			$table->string('audience', 400)->nullable();
			$table->string('homepage')->nullable();
			$table->string('language')->nullable();
			$table->string('writing_style')->nullable();
			$table->string('graphic_style')->nullable();
			$table->string('quora_account', 400)->nullable();
			$table->string('seo_company', 400)->nullable();
			$table->string('article_example', 400)->nullable();
			$table->string('compliance_guidelines', 400)->nullable();
			$table->string('branding_guidelines', 400)->nullable();
			$table->string('branding_logo', 400)->nullable();
			$table->string('avoid_keywords', 400)->nullable();
			$table->string('image_samples', 400)->nullable();
			$table->string('image_webpages', 400)->nullable();
			$table->string('google_access_emails', 400)->nullable();
			$table->string('calls_to_action', 400)->nullable();
			$table->string('transcripts')->nullable();
			$table->string('post_time')->nullable();
			$table->string('review_outlines', 15)->nullable();

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
		Schema::dropIfExists('projects');
	}
}
