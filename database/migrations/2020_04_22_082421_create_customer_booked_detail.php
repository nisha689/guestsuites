<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerBookedDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_booked_detail', function (Blueprint $table) {
            $table->increments('customer_booked_detail_id');
            $table->integer('customer_booked_id')->unsigned()->nullable();
            $table->integer('service_category_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->string('option_id')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();

            $table->foreign('customer_booked_id')->references('customer_booked_id')->on('gs_customer_booked')->onDelete('cascade');
            $table->foreign('service_category_id')->references('service_category_id')->on('gs_service_category')->onDelete('cascade');
            $table->foreign('question_id')->references('question_id')->on('gs_question')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_customer_booked_detail');
    }
}
