<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('video_images');
        Schema::create('video_images', function (Blueprint $table) {
            $table->id();
            $table->string('text', 500);
            $table->string('episodeSeason');
            $table->string('episodeTitle');
            $table->string('episodeNumber');
            $table->integer('number');
            $table->string('startTime', 14);
            $table->string('stopTime', 14);
            $table->string('url', 500);
            $table->timestamps();
        });

        // Because Laravel doesn't support full text search migration
        DB::statement('ALTER TABLE `video_images` ADD FULLTEXT INDEX text_index (text)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_images');
    }
}
