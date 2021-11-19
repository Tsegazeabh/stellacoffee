<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuppingEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupping_events', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->mediumText("detail");
            $table->string("event_place", 512)->nullable();
            $table->dateTime("event_date")->nullable();
            $table->string("video_link")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cupping_events');
    }
}
