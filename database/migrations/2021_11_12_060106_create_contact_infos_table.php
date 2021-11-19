<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("region_id");
            $table->unsignedBigInteger("city_id");
            $table->string("contact_email")->nullable();
            $table->string("contact_person_name", 255)->nullable();
            $table->string("contact_landline_phone")->nullable();
            $table->string("contact_mobile_phone")->nullable();
            $table->decimal("longitude")->nullable();
            $table->decimal("latitude")->nullable();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('region_id')->references('id')->on('regions');
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
        Schema::dropIfExists('contact_infos');
    }
}
