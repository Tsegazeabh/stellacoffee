<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_requests', function (Blueprint $table) {
            $table->id();
            $table->mediumText('first_name');
            $table->mediumText('middle_name');
            $table->mediumText('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->mediumText('detail');
            $table->timestamps();
            $table->boolean('receive_update');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')->on('users');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')
                ->references('id')->on('users');
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')
                ->references('id')->on('users');
            $table->boolean('status');
            $table->unsignedBigInteger('locale_id');
            $table->foreign('locale_id')
                ->references('id')->on('locales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us_requests');
    }
}
