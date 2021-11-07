<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStellaVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stella_videos', function (Blueprint $table) {
            $table->string('video_id')->index();
            $table->string('video_url');
            $table->string('title');
            $table->string('description');
            $table->mediumText('srcset');
            $table->mediumText('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stella_videos');
    }
}
