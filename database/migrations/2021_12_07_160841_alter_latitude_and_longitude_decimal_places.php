<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLatitudeAndLongitudeDecimalPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->decimal('longitude', 18, 15)->nullable()->change();
            $table->decimal('latitude', 18, 15)->nullable()->change();
        });

        Schema::table('export_destinations', function (Blueprint $table) {
            $table->decimal('longitude', 18, 15)->nullable()->change();
            $table->decimal('latitude', 18, 15)->nullable()->change();
        });

        Schema::table('duty_free_locations', function (Blueprint $table) {
            $table->decimal('longitude', 18, 15)->nullable()->change();
            $table->decimal('latitude', 18, 15)->nullable()->change();
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('longitude', 18, 15)->nullable()->change();
            $table->decimal('latitude', 18, 15)->nullable()->change();
        });

        Schema::table('factory_locations', function (Blueprint $table) {
            $table->decimal('longitude', 18, 15)->nullable()->change();
            $table->decimal('latitude', 18, 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->decimal('longitude')->nullable()->change();
            $table->decimal('latitude')->nullable()->change();
        });

        Schema::table('export_destinations', function (Blueprint $table) {
            $table->decimal('longitude')->nullable()->change();
            $table->decimal('latitude')->nullable()->change();
        });

        Schema::table('duty_free_locations', function (Blueprint $table) {
            $table->decimal('longitude')->nullable()->change();
            $table->decimal('latitude')->nullable()->change();
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('longitude')->nullable()->change();
            $table->decimal('latitude')->nullable()->change();
        });

        Schema::table('factory_locations', function (Blueprint $table) {
            $table->decimal('longitude')->nullable()->change();
            $table->decimal('latitude')->nullable()->change();
        });
    }
}
