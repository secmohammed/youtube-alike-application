<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('videos', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('channel_id')->unsigned();
			$table->string('uid');
			$table->string('title');
			$table->string('description');
			$table->boolean('processed')->default(false);
			$table->string('video_id')->nullable();
			$table->string('video_filename')->nullable();
			$table->string('thumbnail')->default('default.png');
			$table->enum('visibility', ['public', 'unlisted', 'private']);
			$table->boolean('allow_votes')->default(false);
			$table->boolean('allow_comments')->default(false);
			$table->integer('processed_percentage')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('videos');
	}
}
