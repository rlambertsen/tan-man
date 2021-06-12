<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCaptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('video_captions');
        Schema::create('video_captions', function (Blueprint $table) {
            $table->id();
            $table->string('text', 500);
            $table->string('episodeSeason');
            $table->string('episodeTitle');
            $table->string('episodeNumber');
            $table->integer('number');
            $table->string('startTime', 14);
            $table->string('stopTime', 14);
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
        Schema::dropIfExists('video_captions');
    }
}
