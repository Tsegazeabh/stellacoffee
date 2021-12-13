<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContactUsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_us_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->dateTime('deleted_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_us_requests', function (Blueprint $table) {
            $table->dropForeign('contact_us_requests_deleted_by_foreign');
            $table->dropColumn(['deleted_by']);
            $table->dropForeign('contact_us_requests_updated_by_foreign');
            $table->dropColumn(['updated_by']);
            $table->dropColumn(['deleted_at']);
        });
    }
}
