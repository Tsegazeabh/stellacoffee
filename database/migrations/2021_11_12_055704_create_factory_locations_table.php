<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("city_id");
            $table->string("title", 255);
            $table->mediumText("detail");
            $table->string("factory_address", 1000);
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
        Schema::dropIfExists('factory_locations');
    }
}
