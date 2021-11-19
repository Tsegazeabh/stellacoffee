<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->string("title", 255);
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
        Schema::dropIfExists('export_destinations');
    }
}
