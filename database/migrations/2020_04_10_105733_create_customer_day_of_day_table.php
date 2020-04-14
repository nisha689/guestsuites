<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDayOfDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_day_of_day', function (Blueprint $table) {
            $table->increments('customer_day_of_day_id');
            $table->integer('customer_booked_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('day_of_day_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('customer_booked_id')->references('customer_booked_id')->on('gs_customer_booked')->onDelete('cascade');

            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('customer_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('day_of_day_id')->references('day_of_day_id')->on('gs_day_of_day')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_day_of_day');
    }
}
