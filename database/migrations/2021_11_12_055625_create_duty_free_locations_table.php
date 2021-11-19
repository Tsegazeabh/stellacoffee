<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDutyFreeLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duty_free_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->string("title", 255);
            $table->string("airport_name", 255);
            $table->string("shop_address", 1000);
            $table->mediumText("detail");
            $table->decimal("longitude")->nullable();
            $table->decimal("latitude")->nullable();
            $table->string("video_link")->nullable();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duty_free_locations');
    }
}
