<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("city_id");
            $table->string("title", 255);
            $table->string("shop_address", 1000);
            $table->mediumText("detail");
            $table->decimal("longitude")->nullable();
            $table->decimal("latitude")->nullable();
            $table->string("video_link")->nullable();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
