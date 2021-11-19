<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('testimonial_name', 255);
            $table->string('testimonial_organization', 255);
            $table->string('testimonial_position', 255);
            $table->mediumText('testimonial_message');
            $table->dateTime('testimonial_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_testimonials');
    }
}
